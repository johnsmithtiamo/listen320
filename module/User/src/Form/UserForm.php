<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator;
use Zend\InputFilter\InputFilterInterface;

class UserForm extends Form {

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->init();
    }

    public function init() {

        $this->add([
            'name' => 'user',
            'type' => Fieldset\UserFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);
        $this->add([
            'name' => 're-password',
            'type' => Element\Password::class,
            'attributes' => [
                'require' => true,
                'id' => 're-password',
                'placeholder' => 'Re-Password',
                'class' => 'form-control input-md'
            ]
        ]);

        $this->add([
            'name' => 'user_csrf',
            'type' => Element\Csrf::class,
        ]);
        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-sm btn-success btn-block'
            ],
        ]);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        $inputFilter->add([
            'name' => 're-password',
            'validators' => [
                [
                    'name' => Validator\Identical::class,
                    'options' => [
                        'token' => ['user' => 'user_password'],
                    ],
                ],
            ]
        ]);
        return parent::setInputFilter($inputFilter);
    }

}
