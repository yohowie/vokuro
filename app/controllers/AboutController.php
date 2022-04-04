<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

class AboutController extends ControllerBase
{
    /**
     * 关于页面
     *
     * @return void
     */
    public function indexAction(): void
    {
//        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->view->setTemplateBefore('public');
    }
}
