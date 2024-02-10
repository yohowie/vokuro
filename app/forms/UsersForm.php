<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Vokuro\Models\Profiles;

class UsersForm extends Form
{
    public function initialize($entity = null, array $options = [])
    {
        if (!empty($options['edit'])) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }
        $this->add($id);

        $name = new Text('name', [
            'placeholder' => '用户名',
        ]);
        $name->addValidators([
            new PresenceOf([
                'message' => '用户名为必填项',
            ]),
        ]);
        $this->add($name);

        $email = new Text('email', [
            'placeholder' => '邮箱',
        ]);
        $email->addValidators([
            new PresenceOf([
                'message' => '电子邮箱为必填项',
            ]),
            new Email([
                'message' => '该电子邮件无效',
            ])
        ]);
        $this->add($email);

        $profiles = Profiles::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ],
        ]);

        $this->add(new Select('profilesId', $profiles, [
            'using' => ['id', 'name'],
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
        ]));

        $this->add(new Select('banned', [
            'Y' => 'Yes',
            'N' => 'No',
        ]));

        $this->add(new Select('suspended', [
            'Y' => 'Yes',
            'N' => "no",
        ]));

        $this->add(new Select('active', [
            'Y' => 'Yes',
            'N' => "no",
        ]));
    }
}
