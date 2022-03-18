<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class RememberTokens extends Model
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
    public $token;
    
    /**
     * @var string
     */
    public $user_agent;
    
    /**
     * @var integer
     */
    public $created_at;
    
    /**
     * initialize
     */
    public function initialize()
    {
        $this->belongsTo('users_id', Users::class, 'id', [
            'alias' => 'user'
        ]);
    }
    
    /**
     * 在创建数据之前赋值
     */
    public function beforeValidationOnCreate()
    {
        $this->created_at = time();
    }
}
