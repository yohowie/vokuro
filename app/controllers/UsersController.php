<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Forms\ChangePasswordForm;

class UsersController extends ControllerBase
{
    public function indexAction(): void
    {
        
    }

    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        $this->view->setVar('form', $form);
    }
}
