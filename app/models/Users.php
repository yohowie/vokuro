<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

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

    public function validation()
    {
        $validator = new Validation();

        $validator->add('email', new Uniqueness([
            'message' => '该邮箱已被注册',
        ]));

        return $this->validate($validator);
    }
}
