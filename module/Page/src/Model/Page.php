<?php

namespace Page\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Admin\Model\SeoAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Admin\Filter\Text\Slug;
use Zend\Filter;
use Zend\Validator;

class Page implements InputFilterAwareInterface, SeoAwareInterface {

    private $page_id;
    private $page_name;
    private $page_slug;
    private $page_content;
    private $page_status;
    private $page_time;
    private $title;
    private $meta_description;
    private $meta_keywords;
    private $meta_robots;
    private $user_id;
//
    private $collections;
    private $inputFilter;

    public function getPageId() {
        return $this->page_id;
    }

    public function getPageName() {
        return $this->page_name;
    }

    public function getPageSlug() {
        if (!$this->page_slug) {
            $slug = new Slug();
            $this->page_slug = $slug->filter($this->page_name);
        }
        return $this->page_slug;
    }

    public function getPageContent() {
        return $this->page_content;
    }

    public function getPageStatus() {
        return $this->page_status;
    }

    public function getPageTime() {
        if (!$this->page_time) {
            $this->page_time = \time();
        }
        return $this->page_time;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getCollections() {
        return $this->collections;
    }

    public function setPageId($page_id) {
        $this->page_id = $page_id;
        return $this;
    }

    public function setPageName($page_name) {
        $this->page_name = $page_name;
        return $this;
    }

    public function setPageSlug($page_slug) {
        $this->page_slug = $page_slug;
        return $this;
    }

    public function setPageContent($page_content) {
        $this->page_content = $page_content;
        return $this;
    }

    public function setPageStatus($page_status) {
        $this->page_status = $page_status;
        return $this;
    }

    public function setPageTime($page_time) {
        $this->page_time = $page_time;
        return $this;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
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
            $this->title = $this->page_name;
        }
        return $this->title;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        $inputFilter->add([
            'name' => 'page_id',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'page_name',
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
            'name' => 'page_slug',
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
            'name' => 'page_content',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ]
        ]);

        $inputFilter->add([
            'name' => 'page_status',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\ToInt::class],
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
