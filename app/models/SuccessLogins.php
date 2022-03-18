<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class SuccessLogins extends Model
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
     * initialize
     */
    public function initialize()
    {
        $this->belongsTo('users_id', Users::class, 'id', [
            'alias' => 'user'
        ]);
    }
}
