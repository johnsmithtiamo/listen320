<?php

namespace Page\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\Form\Element;
use Admin\Form\Element\MetaRobots;
use Zend\Hydrator\Reflection;
use Page\Model\Page;
use CKEditor\Form\Element\CKEditor;
use User\Form\Element\UserId;
use Admin\Form\Element\StatusSelect;

class PageFieldset extends Fieldset {

    public function init() {
        $this->setHydrator(new Reflection());
        $this->setObject(new Page());
        $this->add([
            'name' => 'page_id',
            'type' => Element\Hidden::class
        ]);

        $this->add([
            'name' => 'page_name',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Page Name',
                'class' => 'form-control input-md'
            ]
        ]);

        $this->add([
            'name' => 'page_slug',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Page Slug',
                'class' => 'form-control input-md'
            ]
        ]);

        $this->add([
            'name' => 'page_content',
            'type' => CKEditor::class,
            'attributes' => [
                'id' => 'page_content',
            ],
            'options' => [
                'height' => 160,
            ]
        ]);

        $this->add([
            'name' => 'page_status',
            'type' => StatusSelect::class,
            'attributes' => [
                'value' => 0,
                'class' => 'form-control input-md'
            ]
        ]);

        $this->add([
            'name' => 'user_id',
            'type' => UserId::class,
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
