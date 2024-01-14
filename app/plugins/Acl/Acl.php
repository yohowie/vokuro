<?php
declare(strict_types=1);
namespace Vokuro\Plugins\Acl;

use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Di\Injectable;

class Acl extends Injectable
{
    public function rebuild(): AclMemory
    {
        $acl = new AclMemory();

        return $acl;
    }
}
