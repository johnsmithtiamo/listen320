<?php

namespace Storage\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\Form\Element;
use Zend\Hydrator\Reflection;
use Storage\Model\Storage;

class StorageFieldset extends Fieldset {

    public function init() {
        $this->setHydrator(new Reflection());
        $this->setObject(new Storage);
        $this->add([
            'name' => 'storage_id',
            'type' => Element\Hidden::class,
        ]);
        $this->add([
            'name' => 'storage_name',
            'type' => Element\Text::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Storage Name',
                'class' => 'form-control input-md',
                'autofocus' => true,
            ]
        ]);
        $this->add([
            'name' => 'storage_url',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Storage Slug',
                'class' => 'form-control input-md',
            ]
        ]);
    }

}
