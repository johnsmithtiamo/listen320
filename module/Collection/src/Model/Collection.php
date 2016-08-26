<?php

namespace Collection\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Zend\Filter;
use Zend\Validator;
use Admin\Filter\Text;
use Admin\Filter\Text\Slug;

class Collection implements InputFilterAwareInterface {

    private $collection_id;
    private $collection_name;
    private $collection_slug;
    private $collection_description;
    private $post_count;
    //
    private $inputFilter;

    public function getCollectionId() {
        return $this->collection_id;
    }

    public function getCollectionName() {
        return $this->collection_name;
    }

    public function getCollectionTitle() {
        return $this->collection_slug;
    }

    public function getCollectionSlug() {
        if (!$this->collection_slug) {
            $slug = new Slug();
            $this->collection_slug = $slug->filter($this->collection_name);
        }
        return $this->collection_slug;
    }

    public function getCollectionDescription() {
        return $this->collection_description;
    }

    public function setCollectionId($collection_id) {
        $this->collection_id = $collection_id;
        return $this;
    }

    public function setCollectionName($collection_name) {
        $this->collection_name = $collection_name;
        return $this;
    }

    public function setCollectionSlug($collection_slug) {
        $this->collection_slug = $collection_slug;
        return $this;
    }

    public function setCollectionDescription($collection_description) {
        $this->collection_description = $collection_description;
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
            'name' => 'collection_id',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'collection_name',
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
            'name' => 'collection_slug',
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
                        'max' => 160
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'collection_description',
            'allow_empty' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class]
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 500
                    ]
                ]
            ]
        ]);

        $this->inputFilter = $inputFilter;
        return $this;
    }

}
