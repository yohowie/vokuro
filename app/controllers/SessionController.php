<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Forms\ForgotPasswordForm;
use Vokuro\Forms\LoginForm;
use Vokuro\Forms\SignUpForm;
use Vokuro\Models\ResetPasswords;
use Vokuro\Models\Users;
use Vokuro\Plugins\Auth\Exception as AuthException;

class SessionController extends ControllerBase
{
    /**
     * 初始化控制器
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->view->setTemplateBefore('public');
    }

    /**
     * 用户注册
     *
     * @return void
     */
    public function signupAction()
    {
        $form = new SignUpForm();
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost())) {
                $user = new Users([
                    'name' => $this->request->getPost('name', 'striptags'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->security->hash($this->request->getPost('password')),
                    'profiles_id' => 2
                ]);

                if ($user->save()) {
                    return $this->dispatcher->forward([
                        'controller' => 'index',
                        'action' => 'index'
                    ]);
                }

                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            }
        }

        $this->view->setVar('form', $form);
    }

    /**
     * 用户登录
     *
     * @return unknown|\Phalcon\Http\ResponseInterface
     */
    public function loginAction()
    {
        $form = new LoginForm();

        try {
            if (!$this->request->isPost()) {
                // 如果是get请求判断当前用户是否被记忆
                if ($this->auth->hasRememberMe()) {
                    return $this->auth->loginWithRememberMe();
                }
            } else {
                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    // 验证用户信息
                    $this->auth->check([
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'remember' => $this->request->getPost('remember')
                    ]);

                    return $this->response->redirect('users');
                }
            }
        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->setVar('form', $form);
    }

    public function forgotPasswordAction(): void
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {
            // 仅发送电子邮件是配置值设置为 true
            if ($this->getDI()->get('config')->useMail) {
                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error((string) $message);
                    }
                } else {
                    $user = Users::findFirstByEmail($this->request->getPost('email'));
                    if (!$user) {
                        $this->flash->success('没有与此电子邮件关联的帐户');
                    } else {
                        $resetPassword = new ResetPasswords();
                        $resetPassword->users_id = $user->id;
                        if ($resetPassword->save()) {
                            $this->flash->success('成功！ 请检查您的邮件以获取重置密码的电子邮件');
                        } else {
                            foreach ($resetPassword->getMessages() as $message) {
                                $this->flash->error((string) $message);
                            }
                        }
                    }
                }
            } else {
                $this->flash->warning('电子邮件目前已禁用。 将配置键“useMail”更改为 true 以启用电子邮件。');
            }
        }

        $this->view->setVar('form', $form);
    }

    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }
}
