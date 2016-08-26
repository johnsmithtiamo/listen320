<?php

namespace Collection\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\Form\Element;
use Zend\Hydrator\Reflection;
use Collection\Model\Collection;

class CollectionFieldset extends Fieldset {

    public function init() {
        $this->setHydrator(new Reflection());
        $this->setObject(new Collection);
        $this->add([
            'name' => 'collection_id',
            'type' => Element\Hidden::class,
        ]);
        $this->add([
            'name' => 'collection_name',
            'type' => Element\Text::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Collection Name',
                'class' => 'form-control input-md',
                'autofocus' => true,
            ]
        ]);
        $this->add([
            'name' => 'collection_slug',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Collection Slug',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'collection_description',
            'type' => Element\Textarea::class,
            'attributes' => [
                'class' => 'form-control input-md',
            ]
        ]);
    }

}
