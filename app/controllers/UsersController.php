<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Forms\ChangePasswordForm;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\PasswordChanges;

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
        $this->view->setVar('form', new UsersForm());
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
