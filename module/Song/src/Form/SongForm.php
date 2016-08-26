<?php

namespace Song\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SongForm extends Form {

    public function init() {
        $this->add([
            'name' => 'song',
            'type' => Fieldset\SongFieldset::class,
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);
        $this->add([
            'name' => 'song_csrf',
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
