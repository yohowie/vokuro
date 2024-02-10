<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Email as FormEmail;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Form;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\Identical;
use Phalcon\Filter\Validation\Validator\PresenceOf;

class LoginForm extends Form
{
    public function initialize($entiry = null, array $options = [])
    {
        // 电子邮箱
        $email = new FormEmail('email', [
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

        // 密码
        $password = new Password('password', [
            'placeholder' => '请输入密码'
        ]);
        $password->addValidators([
            new PresenceOf([
                'message' => '密码为必填项'
            ])
        ]);
        $password->clear();

        $this->add($password);

        // 记住账号
        $remember = new Check('remember', [
            'value' => 'yes',
            'id' => 'login-remember'
        ]);
        $remember->setLabel('记住账号');

        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');
        $csrf->addValidators([
            new Identical([
                'value' => $this->security->getRequestToken(),
                'message' => 'CSRF 验证失败'
            ])
        ]);
        $csrf->clear();

        $this->add($csrf);

        // 提交按钮
        $this->add(new Submit('登录', [
            'class' => 'btn btn-primary'
        ]));
    }
}
