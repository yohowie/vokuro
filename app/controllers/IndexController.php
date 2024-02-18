<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

class IndexController extends ControllerBase
{

    /**
     * 首页
     *
     * @return void
     */
    public function indexAction(): void
    {
        $this->logger->info('This is test log.');
        $this->view->setTemplateBefore('public');
    }

}

