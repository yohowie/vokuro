<?php 
declare(strict_types = 1);

namespace Vokuro\Controllers;

class PrivacyController extends ControllerBase
{
    /**
     * 隐私页面
     */
    public function indexAction(): void
    {
        $this->view->setTemplateBefore('public');
    }
}