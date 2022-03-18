<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Profiles extends Model
{
    /**
     * @var integer
     */
    public $id;
    
    /**
     * @var string
     */
    public $name;
}
