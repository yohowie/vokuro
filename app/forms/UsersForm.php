<?php
declare(strict_types=1);

namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

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
    }
}
