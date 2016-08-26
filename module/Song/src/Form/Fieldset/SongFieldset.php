<?php

namespace Song\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\Form\Element;
use Admin\Form\Element\MetaRobots;
use Zend\Hydrator\Reflection;
use Song\Model\Song;
use CKEditor\Form\Element\CKEditor;
use Category\Form\Element\CategorySelect;
use Storage\Form\Element\StorageSelect;
use User\Form\Element\UserId;
use Admin\Form\Element\StatusSelect;
use Collection\Form\Element\CollectionMultiCheckbox;

class SongFieldset extends Fieldset {

    public function init() {
        $this->setHydrator(new Reflection());
        $this->setObject(new Song());
        $this->add([
            'name' => 'song_id',
            'type' => Element\Hidden::class
        ]);

        $this->add([
            'name' => 'song_name',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Song Name',
                'class' => 'form-control input-md'
            ]
        ]);

        $this->add([
            'name' => 'song_slug',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => 'Song Slug',
                'class' => 'form-control input-md'
            ]
        ]);

        $this->add([
            'name' => 'song_lyric',
            'type' => CKEditor::class,
            'attributes' => [
                'id' => 'song_lyric',
            ],
            'options' => [
                'height' => 160,
            ]
        ]);

        $this->add([
            'name' => 'song_status',
            'type' => StatusSelect::class,
            'attributes' => [
                'value' => 0,
                'class' => 'form-control input-md'
            ]
        ]);
        $this->add([
            'name' => 'collections',
            'type' => CollectionMultiCheckbox::class,
        ]);

        $this->add([
            'name' => 'storage_id',
            'type' => StorageSelect::class,
            'attributes' => [
                'class' => 'form-control input-md'
            ]
        ]);
        $this->add([
            'name' => 'storage_path',
            'type' => Element\Text::class,
            'attributes' => [
                'placeholder' => '/path/to/filename.mp3',
                'class' => 'form-control input-md'
            ]
        ]);
        $this->add([
            'name' => 'category_id',
            'type' => CategorySelect::class,
            'attributes' => [
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
