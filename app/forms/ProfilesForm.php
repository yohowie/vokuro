<?Php
declare(strict_types=1);
namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Filter\Validation\Validator\PresenceOf;

class ProfilesForm extends Form
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
            'placeholder' => '名称',
        ]);
        $name->addValidators([
            new PresenceOf([
                'message' => '名称为必填项'
            ])
        ]);
        $this->add($name);

        $this->add(new Select('active', [
            'Y' => 'Yes',
            'N' => 'No'
        ]));
    }
}
