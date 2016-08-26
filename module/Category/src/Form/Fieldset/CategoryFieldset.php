<?php

namespace Category\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\Form\Element;
use Zend\Hydrator\Reflection;
use Category\Model\Category;
use Admin\Form\Element\MetaRobots;

class CategoryFieldset extends Fieldset {

    public function init() {
        $this->setHydrator(new Reflection());
        $this->setObject(new Category);
        $this->add([
            'name' => 'category_id',
            'type' => Element\Hidden::class,
        ]);
        $this->add([
            'name' => 'category_name',
            'type' => Element\Text::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Category Name',
                'class' => 'form-control input-md',
                'autofocus' => true,
            ]
        ]);
        $this->add([
            'name' => 'category_slug',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Category Slug',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'category_description',
            'type' => Element\Textarea::class,
            'attributes' => [
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'category_order',
            'type' => Element\Number::class,
            'attributes' => [
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'category_visible',
            'type' => Element\Select::class,
            'options' => [
                'value_options' => [
                    0 => 'Disable',
                    1 => 'Enable'
                ]
            ],
            'attributes' => [
                'class' => 'form-control input-md',
            ]
        ]);

        $this->add([
            'name' => 'title',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Title',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'meta_description',
            'type' => Element\Textarea::class,
            'attributes' => [
                'placeholder' => 'Meta Description',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'meta_keywords',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Meta Keywords',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'meta_robots',
            'type' => MetaRobots::class,
            'attributes' => [
                'class' => 'form-control input-md',
            ]
        ]);
    }

}
