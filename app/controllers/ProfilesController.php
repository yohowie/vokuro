<?php
declare(strict_types=1);
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ProfilesForm;
use Vokuro\Models\Profiles;

class ProfilesController extends ControllerBase
{
    public function initialize(): void
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction()
    {
        $this->persistent->conditions = null;
        $this->view->setVar('form', new ProfilesForm());
    }

    /**
     * 搜索 Profile
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            $query = Criteria::fromInput(
                $this->di,
                Profiles::class,
                $this->request->getPost()
            );
            $searchParams = $query->getParams();
            unset($searchParams['di']);
            $this->persistent->searchParams = $searchParams;
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $profiles = Profiles::find($parameters);
        if (count($profiles) == 0) {
            $this->flash->notice('搜索没有找到任何 profiles');
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        $paginator = new Paginator([
            'model' => Profiles::class,
            'parameters' => $parameters,
            'limit' => 10,
            'page' => $this->request->getQuery('page', 'int', 1)
        ]);

        $this->view->setVar('page', $paginator->paginate());
    }

    /**
     * 创建新的Profile
     */
    public function createAction(): void
    {
        if ($this->request->isPost()) {
            $profile = new Profiles([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ]);

            if (!$profile->save()) {
                foreach ($profile->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $this->flash->success('Profle 资料创建成功');
            }
        }

        $this->view->setVar('form', new ProfilesForm(null));
    }

    /**
     * 编辑 Profile
     */
    public function editAction($id)
    {
        $profile = Profiles::findFirstById($id);
        if (!$profile) {
            $this->flash->error('找不到Profile');
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if ($this->request->isPost()) {
            $profile->assign([
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ]);

            if (!$profile->save()) {
                foreach ($profile->getMessages as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $this->flash->success('Profile 已成功更新');
            }
        }

        $this->view->setVars([
            'form' => new ProfilesForm(null, ['edit' => true]),
            'profile' => $profile
        ]);
    }

    /**
     * 删除 profile
     */
    public function deleteAction($id)
    {
        $profile = Profiles::findFirstById($id);
        if (!$profile) {
            $this->flash->error('找不到 Profile');
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if (!$profile->delete()) {
            foreach ($profile->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        } else {
            $this->flash->success('Profile 已删除');
        }

        return $this->dispatcher->forward([
            'action' => 'index'
        ]);
    }
}
