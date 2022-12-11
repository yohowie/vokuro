<?php
declare(strict_types = 1);

namespace Vokuro\Controllers;

use Vokuro\Models\ResetPasswords;

class UserControlController extends ControllerBase
{
    public function resetPasswordAction()
    {
        $code = $this->dispatcher->getParam('code');

        $resetPassword = ResetPasswords::findFirstByCode($code);
        if (!$resetPassword instanceof ResetPasswords) {
            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        if ($resetPassword->reset != 'N') {
            return $this->dispatcher->forward([
                'controller' => 'session',
                'action' => 'login'
            ]);
        }

        $resetPassword->reset = 'Y';

        if (!$resetPassword->save()) {
            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            return $this->dispatcher->forward([
                'controller' => 'index',
                'action' => 'index'
            ]);
        }

        $this->auth->authUserById($resetPassword->users_id);
        $this->flash->success('请重新设置您的密码');

        return $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'changePassword'
        ]);
    }
}
