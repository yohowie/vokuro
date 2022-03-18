<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

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
        $this->must_change_password = 'N';

        $this->suspended = 'N';

        $this->banned =  'N';
    }
}
