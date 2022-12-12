<?php
declare(strict_types = 1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ChangePasswordForm extends Form
{
    public function initialize()
    {
        // 密码
        $password = new Password('password');
        $password->setLabel('密码');
        $password->addValidators([
            new PresenceOf([
                'message' => '密码为必填项'
            ]),
            new StringLength([
                'min' => 8,
                'messageMinimum' => '密码太短, 最少 8 个字符'
            ]),
            new Confirmation([
                'message' => '两次输入密码不一致',
                'with' => 'confirmPassword'
            ])
        ]);

        $this->add($password);

        // 确认密码
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('确认密码');
        $confirmPassword->addValidators([
            new PresenceOf([
                'message' => '确认密码为必填项'
            ])
        ]);

        $this->add($confirmPassword);
    }
}
