<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Forms\LoginForm;
use Vokuro\Forms\SignUpForm;
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
}
