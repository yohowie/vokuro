<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher): bool
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();

        if ($this->acl->isPrivate($controllerName)) {
            $identity = $this->auth->getIdentity();
            if (!is_array($identity)) {
                $this->flash->notice('您无权访问此模块：私有');
                $dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'index',
                ]);

                return false;
            }

            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {
                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
                    $dispatcher->forward([
                        'controller' => $controllerName,
                        'action' => 'index',
                    ]);
                } else {
                    $dispatcher->forward([
                        'controller' => 'index',
                        'action' => 'index'
                    ]);
                }

                return false;
            }
        }
        return true;
    }
}
