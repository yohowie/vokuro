<?php
declare(strict_types=1);
namespace Vokuro\Plugins\Acl;

use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Component as AclComponent;
use Phalcon\Acl\Enum as AclEnum;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Di\Injectable;
use Vokuro\Models\Profiles;

class Acl extends Injectable
{
    const APC_CACHE_VARIABLE_KEY = 'vokuro-acl';
    /**
     * ACL Object
     *
     * @var AbstractAdapter|mixed
     */
    private $acl;

    /**
     * ACL缓存文件的文件路径。
     *
     * @var string
     */
    private $filePath;

    /**
     * 定义被视为“私有”的资源。 这些控制器 => 操作需要身份验证。
     * @var array
     */
    private $privateResources = [];

    private $actionDescriptions = [
        'index'          => 'Access',
        'search'         => 'Search',
        'create'         => 'Create',
        'edit'           => 'Edit',
        'delete'         => 'Delete',
        'changePassword' => 'Change password',
    ];

    public function isPrivate($controllerName): bool
    {
        $controllerName = strtolower($controllerName);
        return isset($this->privateResources[$controllerName]);
    }

    public function isAllowed($profile, $controller, $action): bool
    {
        return $this->getAcl()->isAllowed($profile, $controller, $action);
    }

    public function getAcl()
    {
        if (is_object($this->acl)) {
            return $this->acl;
        }

        if (function_exists('apc_fetch')) {
            $acl = apc_fetch(self::APC_CACHE_VARIABLE_KEY);
            if ($acl !== false) {
                $this->acl = $acl;
                return $acl;
            }
        }

        $filePath = $this->getFilePath();
        if (!file_exists($filePath)) {
            $this->acl = $this->rebuild();
            return $this->acl;
        }

        $data = file_get_contents($filePath);
        $this->acl = unserialize($data);

        if (function_exists('apc_store')) {
            apc_store(self::APC_CACHE_VARIABLE_KEY);
        }

        return $this->acl;
    }

    public function getPermissions(Profiles $profiles): array
    {
        $permissions = [];
        foreach($profile->getPermissions() as $permission) {
            $permissions[$permission->resource .'.'. $permission->action] = true;
        }

        return $permissions;
    }

    public function getResources(): array
    {
        return $this->privateResources;
    }

    public function getActionDescription($action): string
    {
        return $this->actionDescriptions[$action] ?? $action;
    }

    public function rebuild(): AclMemory
    {
        $acl = new AclMemory();
        $acl->setDefaultAction(AclEnum::DENY);

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y'
            ],
        ]);

        foreach ($profiles as $profile) {
            $acl->addRole(new AclRole($profile->name));
        }
        foreach ($this->privateResources as $resource => $actions) {
            $acl->addComponent(new AclComponent($resource), $actions);
        }

        foreach ($profiles as $profile) {
            foreach ($profile->getPermissions() as $permission) {
                $acl->allow($profile->name, $permission->resource, $permission->action);
            }
            $acl->allow($profile->name, 'users', 'changePassword');
        }

        $filePath = $this->getFilePath();
        if (touch($filePath) && is_writable($filePath)) {
            file_put_contents($filePath, serialize($acl));
            if (function_exists('apc_store')) {
                apc_store(self::APC_CACHE_VARIABLE_KEY, $acl);
            }
        } else {
            $this->flash->error('用户没有创建 ACL 列表的写入权限 '. $filePath);
        }

        return $acl;
    }

    /**
     * 设置acl缓存文件
     */
    protected function getFilePath()
    {
        if(!isset($this->filePath)) {
            $this->filePath = rtrim($this->config->application->cacheDir, '\\/') .'/acl/data.txt';
        }

        return $this->filePath;
    }

    /**
     * 将私有资源数组添加到 ACL 对象。
     *
     * @param array $resources
     */
    public function addPrivateResources(array $resources)
    {
        if (empty($resources)) {
            return ;
        }

        $this->privateResources = array_merge($this->privateResources, $resources);
        if (is_object($this->acl)) {
            $this->acl = $this->rebuild();
        }
    }
}
