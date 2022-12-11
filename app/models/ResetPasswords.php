<?php
declare(strict_types = 1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class ResetPasswords extends Model
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
    public $code;

    /**
     * @var integer
     */
    public $created_at;

    /**
     * @var integer
     */
    public $modified_at;

    /**
     * @var string
     */
    public $reset;

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

        // 生成随机确认码
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // 将状态设置为未确认
        $this->reset = 'N';
    }

    /**
     * 在更新确认之前设置时间戳
     */
    public function beforeValidationOnUpdate()
    {
        $this->modified_at = time();
    }

    public function afterCreate()
    {
        $this->getDI()->getMail()->send([
            $this->user->email => $this->user->name
        ], '重置你的密码', 'reset', [
            'resetUrl' => '/reset-password/'. $this->code .'/'. $this->user->email
        ]);
    }
}
