<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Email as FormEmail;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Filter\Validation\Validator\Confirmation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\Identical;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength;

class SignUpForm extends Form
{
    /**
     * 创建注册表单
     *
     * @param $entiry
     * @param array $options
     * @return void
     */
    public function initialize($entiry = null, array $options = [])
    {
        // 用户名
        $name = new Text('name');
        $name->setLabel('用户名');
        $name->addValidators([
            new PresenceOf([
                'message' => '账号为必填项'
            ]),
        ]);

        $this->add($name);

        // 邮箱
        $email = new FormEmail('email');
        $email->setLabel('邮箱');
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

        // 条款和规则
        $terms = new Check('terms', [
            'value' => 'yes'
        ]);
        $terms->setLabel('接受条款和规则');
        $terms->addValidators([
            new Identical([
                'value' => 'yes',
                'message' => '必须接受条款和规则'
            ])
        ]);

        $this->add($terms);

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
        $this->add(new Submit('注册', [
            'class' => 'btn btn-success'
        ]));
    }

    /**
     * 为元素打印错误消息
     *
     * @param string $name
     * @return \Phalcon\Messages\MessageInterface|string
     */
    public function messages(string $name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                return $message;
            }
        }

        return '';
    }
}
