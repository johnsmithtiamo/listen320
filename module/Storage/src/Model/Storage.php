<?php

namespace Storage\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator;
use Zend\Filter;

class Storage implements InputFilterAwareInterface {

    private $storage_id;
    private $storage_name;
    private $storage_url;
//
    private $inputFilter;

    public function getStorageId() {
        return $this->storage_id;
    }

    public function getStorageName() {
        return $this->storage_name;
    }

    public function getStorageUrl() {
        return $this->storage_url;
    }

    public function setStorageId($storage_id) {
        $this->storage_id = $storage_id;
        return $this;
    }

    public function setStorageName($storage_name) {
        $this->storage_name = $storage_name;
        return $this;
    }

    public function setStorageUrl($storage_url) {
        $this->storage_url = $storage_url;
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
            'name' => 'storage_id',
            'filters' => [
                ['name' => Filter\ToInt::class]
            ]
        ]);
        $inputFilter->add([
            'name' => 'storage_name',
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
            'name' => 'storage_url',
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
        $this->inputFilter = $inputFilter;
        return $this;
    }

}
