<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

class IndexController extends ControllerBase
{
    public function initialize(): void
    {
        $this->view->setTemplateBefore('public');
    }
    /**
     * 首页
     *
     * @return void
     */
    public function indexAction(): void
    {
        $this->logger->info('This is test log.');
    }

}

