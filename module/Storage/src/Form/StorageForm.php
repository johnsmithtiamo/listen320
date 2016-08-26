<?php

namespace Storage\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class StorageForm extends Form {

    public function init() {
        $this->add([
            'name' => 'storage',
            'type' => Fieldset\StorageFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);
        $this->add([
            'name' => 'storage_csrf',
            'type' => Element\Csrf::class,
        ]);
        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-sm btn-success'
            ],
        ]);
        $this->add([
            'name' => 'reset',
            'type' => Element::class,
            'attributes' => [
                'value' => 'Reset',
                'class' => 'btn btn-sm btn-info'
            ],
        ]);
    }

}
