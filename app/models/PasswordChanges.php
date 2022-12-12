<?php
declare(strict_types = 1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class PasswordChanges extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $users_id;

    /**
     * @var string
     */
    public $ip_address;

    /**
     * @var string
     */
    public $user_agent;

    /**
     * @var integer
     */
    public $created_at;

    public function initialize()
    {
        $this->belongsTo('users_id', Users::class, 'id', [
            'alias' => 'user'
        ]);
    }

    /**
     * 在创建用户之前分配密码
     */
    public function beforeValidationOnCreate()
    {
        $this->created_at = time();
    }
}
