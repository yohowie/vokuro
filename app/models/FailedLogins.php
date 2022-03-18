<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class FailedLogins extends Model
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
     * @var integer
     */
    public $attempted;
    
    /**
     * initialize
     */
    public function initialize()
    {
        $this->belongsTo('usersId', Users::class, 'id', [
            'alias' => 'user'
        ]);
    }
}
