<?php
declare(strict_types=1);

namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Users extends Model
{
    /**
     * @var integer
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string
     */
    public string $must_change_password;

    /**
     * @var string
     */
    public string $profiles_id;

    /**
     * @var string
     */
    public string $banned;

    /**
     * @var string
     */
    public string $suspended;

    /**
     * @var string
     */
    public string $active;

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
