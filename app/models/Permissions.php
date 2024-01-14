<?php
declare(strict_types=1);
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Permissions extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $profiles_id;

    /**
     * @var string
     */
    public $resource;

    /**
     * @var string
     */
    public $action;

    public function initialize()
    {
        $this->belongsTo('profiles_id', Profiles::class, 'id', [
            'alias' => 'profile'
        ]);
    }
}
