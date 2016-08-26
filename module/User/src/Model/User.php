<?php

namespace User\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter;
use Zend\Validator;
use Zend\I18n\Validator\Alnum;

class User implements InputFilterAwareInterface {

    private $user_id;
    private $user_name;
    private $user_first_name;
    private $user_last_name;
    private $user_password;
    private $user_email;
    private $user_role;
    private $user_last_login;
    private $user_time_created;
    private $user_status;
    private $user_active;
    // Filter
    private $inputFilter;

    public function getUserId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function getUserFirstName() {
        return $this->user_first_name;
    }

    public function getUserLastName() {
        return $this->user_last_name;
    }

    public function getUserPassword() {
        return $this->user_password;
    }

    public function getUserEmail() {
        return $this->user_email;
    }

    public function getUserRole() {
        return $this->user_role;
    }

    public function getUserLastLogin() {
        return $this->user_last_login;
    }

    public function getUserTimeCreated() {
        return $this->user_time_created;
    }

    public function getUserStatus() {
        return $this->user_status;
    }

    public function getUserActive() {
        return $this->user_active;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    public function setUserName($user_name) {
        $this->user_name = $user_name;
        return $this;
    }

    public function setUserFirstName($user_first_name) {
        $this->user_first_name = $user_first_name;
        return $this;
    }

    public function setUserLastName($user_last_name) {
        $this->user_last_name = $user_last_name;
        return $this;
    }

    public function setUserPassword($user_password) {
        $this->user_password = $user_password;
        return $this;
    }

    public function setUserEmail($user_email) {
        $this->user_email = $user_email;
        return $this;
    }

    public function setUserRole($user_role) {
        $this->user_role = $user_role;
        return $this;
    }

    public function setUserLastLogin($user_last_login) {
        $this->user_last_login = $user_last_login;
        return $this;
    }

    public function setUserTimeCreated($user_time_created) {
        $this->user_time_created = $user_time_created;
        return $this;
    }

    public function setUserStatus($user_status) {
        $this->user_status = $user_status;
        return $this;
    }

    public function setUserActive($user_active) {
        $this->user_active = $user_active;
        return $this;
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $this->setInputFilter(new InputFilter());
        }
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        $inputFilter->add([
            'name' => 'user_id',
            'required' => true,
            'filters' => [
                ['name' => Filter\ToInt::class],
            ],
        ]);
        $inputFilter->add([
            'name' => 'user_name',
            'require' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 4,
                        'max' => 64
                    ]
                ],
                [
                    'name' => Alnum::class,
                    'options' => [
                        'allowWhiteSpace' => false
                    ]
                ]
            ],
        ]);
        $inputFilter->add([
            'name' => 'user_first_name',
            'require' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 64
                    ]
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'user_last_name',
            'require' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 64
                    ]
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'user_password',
            'require' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 4,
                        'max' => 32
                    ]
                ],
            ],
        ]);
        $inputFilter->add([
            'name' => 'user_email',
            'require' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 96
                    ]
                ]
            ],
        ]);
        $inputFilter->add([
            'name' => 'user_role',
            'require' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
                ['name' => Filter\StripTags::class],
            ],
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'max' => 32
                    ]
                ]
            ],
        ]);
        $this->inputFilter = $inputFilter;
        return $this;
    }

}
