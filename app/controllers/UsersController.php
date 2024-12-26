<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Forms\ChangePasswordForm;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\PasswordChanges;
use Vokuro\Models\Users;

class UsersController extends ControllerBase
{
    /**
     * 初始化控制器
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->view->setTemplateBefore('private');
    }

    public function indexAction(): void
    {
        $builder = Criteria::fromInput($this->getDI(), Users::class, $this->request->getQuery());
        $count = Users::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('没有找到任何用户');
            $this->dispatcher->forward([
                'action' => 'index'
            ]);

            return ;
        }

        $paginator = new Paginator([
            'builder' => $builder->createBuilder(),
            'limit' => 10,
            'page' => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->setVars([
            'form' => new UsersForm(),
            'page' => $paginator->paginate(),
        ]);
    }

    /**
     * 搜索用户
     */
    public function searchAction(): void
    {
        $builder = Criteria::fromInput($this->getDI(), Users::class, $this->request->getQuery());

        $count = Users::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('没有找到任何用户');
            $this->dispatcher->forward([
                'action' => 'index'
            ]);

            return ;
        }

        $paginator = new Paginator([
            'builder' => $builder->createBuilder(),
            'limit' => 10,
            'page' => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->setVar('page', $paginator->paginate());
    }

    /**
     * 创建用户
     */
    public function createAction(): void
    {
        $form = new UsersForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $user = new Users([
                    'name' => $this->request->getPost('name', 'striptags'),
                    'profiles_id' => $this->request->getPost('profilesId', 'int'),
                    'email' => $this->request->getPost('email', 'email'),
                ]);

                if (!$user->save()) {
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success('用户创建成功');
                }
            }
        }

        $this->view->setVar('form', $form);
    }

    public function editAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found.');
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        $form = new UsersForm($user, [
            'edit' => true
        ]);

        if ($this->request->isPost()) {
            $user->assign([
                'name' => $this->request->getPost('name', 'striptags'),
                'profilesId' => $this->request->getPost('prodilesId', 'int'),
                'email' => $this->request->getPost('email', 'email'),
                'banned' => $this->request->getPost('banned'),
                'suspended' => $this->request->getPost('suspended'),
                'active' => $this->request->getPost('avtive')
            ]);

            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                if (!$user->save()) {
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success('User was updated successfully.');
                }
            }
        }
        $this->view->setVars([
            'user' => $user,
            'form' => $form,
        ]);
    }

    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found.');
            return $this->dispatcher->forward([
                'action' => 'index'
            ]);
        }

        if (!$user->delete()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
        } else {
            $this->flash->success('User was deleted.');
        }

        return $this->dispatcher->forward([
            'action' => 'index',
        ]);
    }

    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $user = $this->auth->getUser();
                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';
                if (!$user->save()) {
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                }

                $passwordChange = new PasswordChanges();
                $passwordChange->user = $user;
                $passwordChange->ip_address = $this->request->getClientAddress();
                $passwordChange->user_agent = $this->request->getUserAgent();
                if (!$passwordChange->save()) {
                    foreach ($passwordChange->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $this->flash->success('您的密码已更改成功');
                }
            }
        }

        $this->view->setVar('form', $form);
    }
}
