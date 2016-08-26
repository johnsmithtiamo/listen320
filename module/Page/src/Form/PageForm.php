<?php

namespace Page\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PageForm extends Form {

    public function init() {
        $this->add([
            'name' => 'page',
            'type' => Fieldset\PageFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);
        $this->add([
            'name' => 'page_csrf',
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
