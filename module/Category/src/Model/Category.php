<?php

namespace Category\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Filter;
use Zend\Validator;
use Admin\Filter\Text;
use Admin\Filter\Text\Slug;
use Admin\Model\SeoAwareInterface;

class Category implements InputFilterAwareInterface, SeoAwareInterface {

    private $category_id;
    private $category_name;
    private $title;
    private $category_slug;
    private $category_description;
    private $post_count;
    private $category_order;
    private $category_visible;
    private $meta_description;
    private $meta_keywords;
    private $meta_robots;
    //
    private $inputFilter;

    public function getCategoryId() {
        return $this->category_id;
    }

    public function getCategoryName() {
        return $this->category_name;
    }

    public function getCategoryTitle() {
        return $this->category_title;
    }

    public function getCategorySlug() {
        if (!$this->category_slug) {
            $slug = new Slug();
            $this->category_slug = $slug->filter($this->category_name);
        }
        return $this->category_slug;
    }

    public function getCategoryDescription() {
        return $this->category_description;
    }

    public function getCategoryOrder() {
        return $this->category_order;
    }

    public function getCategoryVisible() {
        return $this->category_visible;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
        return $this;
    }

    public function setCategoryName($category_name) {
        $this->category_name = $category_name;
        return $this;
    }

    public function setCategorySlug($category_slug) {
        $this->category_slug = $category_slug;
        return $this;
    }

    public function setCategoryDescription($category_description) {
        $this->category_description = $category_description;
        return $this;
    }

    public function setCategoryOrder($category_order) {
        $this->category_order = $category_order;
        return $this;
    }

    public function setCategoryVisible($category_visible) {
        $this->category_visible = $category_visible;
        return $this;
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $this->setInputFilter(new InputFilter);
        }
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        $inputFilter->add([
            'name' => 'category_id',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'category_name',
            'required' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 100
                    ]
                ]
            ]
        ]);
        $inputFilter->add([
            'name' => 'category_slug',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
                ['name' => Text\Slug::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 100
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'category_description',
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
            'name' => 'category_order',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'category_visible',
            'filters' => [
                ['name' => Filter\ToInt::class]
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

        $this->inputFilter = $inputFilter;
        return $this;
    }

    public function getMetaDescription() {
        return $this->meta_description;
    }

    public function getMetaKeywords() {
        return $this->meta_description;
    }

    public function getMetaRobots() {
        return $this->meta_robots;
    }

    public function getTitle() {
        if (!$this->title) {
            $this->title = $this->category_name;
        }
        return $this->title;
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
