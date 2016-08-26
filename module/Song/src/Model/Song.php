<?php

namespace Song\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Admin\Model\SeoAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Admin\Filter\Text\Slug;
use Zend\Filter;
use Zend\Validator;

class Song implements InputFilterAwareInterface, SeoAwareInterface {

    private $song_id;
    private $song_name;
    private $song_slug;
    private $song_lyric;
    private $song_status;
    private $song_time;
    private $storage_id;
    private $storage_path;
    private $title;
    private $meta_description;
    private $meta_keywords;
    private $meta_robots;
    private $category_id;
    private $user_id;
//
    private $collections;
    private $inputFilter;

    public function getSongId() {
        return $this->song_id;
    }

    public function getSongName() {
        return $this->song_name;
    }

    public function getSongSlug() {
        if (!$this->song_slug) {
            $slug = new Slug();
            $this->song_slug = $slug->filter($this->song_name);
        }
        return $this->song_slug;
    }

    public function getSongLyric() {
        return $this->song_lyric;
    }

    public function getSongStatus() {
        return $this->song_status;
    }

    public function getSongTime() {
        if (!$this->song_time) {
            $this->song_time = \time();
        }
        return $this->song_time;
    }

    public function getStorageId() {
        return $this->storage_id;
    }

    public function getStoragePath() {
        return $this->storage_path;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getCollections() {
        return $this->collections;
    }

    public function setSongId($song_id) {
        $this->song_id = $song_id;
        return $this;
    }

    public function setSongName($song_name) {
        $this->song_name = $song_name;
        return $this;
    }

    public function setSongSlug($song_slug) {
        $this->song_slug = $song_slug;
        return $this;
    }

    public function setSongLyric($song_lyric) {
        $this->song_lyric = $song_lyric;
        return $this;
    }

    public function setSongStatus($song_status) {
        $this->song_status = $song_status;
        return $this;
    }

    public function setSongTime($song_time) {
        $this->song_time = $song_time;
        return $this;
    }

    public function setStorageId($storage_id) {
        $this->storage_id = $storage_id;
        return $this;
    }

    public function setStoragePath($storage_path) {
        $this->storage_path = $storage_path;
        return $this;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
        return $this;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    public function setCollections(array $collections) {
        $this->collections = $collections;
        return $this;
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $this->setInputFilter(new InputFilter);
        }
        return $this->inputFilter;
    }

    public function getMetaDescription() {
        return $this->meta_description;
    }

    public function getMetaKeywords() {
        return $this->meta_keywords;
    }

    public function getMetaRobots() {
        return $this->meta_robots;
    }

    public function getTitle() {
        if (!$this->title) {
            $this->title = $this->song_name;
        }
        return $this->title;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        $inputFilter->add([
            'name' => 'song_id',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'song_name',
            'required' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 160
                    ]
                ]
            ]
        ]);
        $inputFilter->add([
            'name' => 'song_slug',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
                ['name' => Slug::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 160
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'song_lyric',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ]
        ]);

        $inputFilter->add([
            'name' => 'song_status',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\ToInt::class],
            ]
        ]);
        $inputFilter->add([
            'name' => 'storage_id',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'storage_path',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 160
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'title',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 160
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'meta_description',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 200
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'meta_keywords',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 200
                    ]
                ]
            ]
        ]);
        $inputFilter->add([
            'name' => 'meta_robots',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 15
                    ]
                ]
            ]
        ]);
        $this->inputFilter = $inputFilter;
        return $this;
    }

    public function setMetaDescription($meta_description) {
        $this->meta_description = $meta_description;
        return $this;
    }

    public function setMetaKeywords($meta_keyword) {
        $this->meta_keywords = $meta_keyword;
        return $this;
    }

    public function setMetaRobots($meta_robots) {
        $this->meta_robots = $meta_robots;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

}
