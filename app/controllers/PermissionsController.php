<?php
declare(strict_types=1);
namespace Vokuro\Controllers;

use Vokuro\Models\Permissions;
use Vokuro\Models\Profiles;

class PermissionsController extends ControllerBase
{
    public function initialize(): void
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction(): void
    {
        if ($this->request->isPost()) {
            $profile = Profiles::findFirstById($this->request->getPost('profileId'));
            if ($profile) {
                if ($this->request->hasPost('permissions') && $this->request->hasPost('submit')) {
                    $profile->getPermissions()->delete();
                    foreach ($this->request->getPost('permissions') as $permission) {
                        $parts = explode('.', $permission);
                        $permission = new Permissions();
                        $permission->profiles_id = $profile->id;
                        $permission->resource = $parts[0];
                        $permission->action = $parts[1];
                        $permission->save();
                    }
                    $this->flash->success('权限更新成功');
                }
                $this->acl->rebuild();

                $this->view->setVar('permissions', $this->acl->getPermissions($profile));
            }
            $this->view->setVar('profile', $profile);
        }

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ],
        ]);

        $profilesSelect = $this->tag->select([
            'profileId',
            $profiles,
            'using' => [
                'id',
                'name'
            ],
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
            'class' => 'form-control mr-sm-2',
        ]);

        $this->view->setVar('profilesSelect', $profilesSelect);
    }
}
