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

    public function initialize()
    {
        $this->hasMany('id', Users::class, 'profiles_id', [
            'alias' => 'users',
            'foreignKey' => [
                'message' => '无法删除配置文件，因为它已用于用户'
            ]
        ]);
    }
}
