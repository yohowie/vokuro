<?php
declare(strict_types = 1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;

class ForgotPasswordForm extends Form
{
    public function initialize($entiry = null, array $options = [])
    {
        // 电子邮箱
        $email = new Text('email', [
            'placeholder' => '请输入电子邮箱'
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => '电子邮箱为必填项'
            ]),
            new Email([
                'message' => '电子邮箱无效'
            ])
        ]);

        $this->add($email);

        $this->add(new Submit('Send', [
            'class' => 'btn btn-primary'
        ]));
    }
}
