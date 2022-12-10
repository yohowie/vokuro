<?php 
declare(strict_types = 1);

namespace Vokuro\Controllers;

class TermsController extends ControllerBase
{
    /**
     * 条款页面
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('public');
    }
}
