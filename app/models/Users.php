<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Security;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Uniqueness;

class Users extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $must_change_password;

    /**
     * @var string
     */
    public $profiles_id;

    /**
     * @var string
     */
    public $banned;

    /**
     * @var string
     */
    public $suspended;

    /**
     * @var string
     */
    public $active;

    /**
     * initialize
     */
    public function initialize()
    {
        $this->hasOne('profiles_id', Profiles::class, 'id', [
            'alias' => 'profile',
            'reusable' => true
        ]);

        $this->hasMany('id', SuccessLogins::class, 'usersId', [
            'alias'      => 'successLogins',
            'foreignKey' => [
                'message' => 'User cannot be deleted because he/she has activity in the system',
            ],
        ]);

        $this->hasMany('id', PasswordChanges::class, 'usersId', [
            'alias'      => 'passwordChanges',
            'foreignKey' => [
                'message' => 'User cannot be deleted because he/she has activity in the system',
            ],
        ]);

        $this->hasMany('id', ResetPasswords::class, 'usersId', [
            'alias'      => 'resetPasswords',
            'foreignKey' => [
                'message' => 'User cannot be deleted because he/she has activity in the system',
            ],
        ]);
    }

    /**
     * 在创建用户之前分配密码
     *
     * @return void
     */
    public function beforeValidationOnCreate(): void
    {
        if (empty($this->password)) {
            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));
            $this->must_change_password = 'Y';

            $security = $this->getDI()->getShared('security');
            $this->password = $security->hash($tempPassword);
        } else {
            $this->must_change_password = 'N';
        }

        if ($this->getDI()->get('config')->useMail) {
            $this->active = 'N';
        } else {
            $this->active = 'Y';
        }

        $this->suspended = 'N';

        $this->banned =  'N';
    }

    public function afterCreate()
    {
        // Only send the confirmation email if emails are turned on in the config
        if ($this->getDI()->get('config')->useMail && $this->active == 'N') {
            $emailConfirmation          = new EmailConfirmations();
            $emailConfirmation->usersId = $this->id;

            if ($emailConfirmation->save()) {
                $this->getDI()
                    ->getFlash()
                    ->notice('A confirmation mail has been sent to ' . $this->email);
            }
        }
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add('email', new Uniqueness([
            'message' => '该邮箱已被注册',
        ]));

        return $this->validate($validator);
    }
}
