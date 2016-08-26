<?php

namespace User\Form\Fieldset;

use Zend\Form\Fieldset;
use Admin\Form\Element;
use Zend\Form\Element as ZendElement;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use User\Model\User;

class UserFieldset extends Fieldset {

    public function init() {
        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new User());

        $this->add([
            'name' => 'user_id',
            'type' => ZendElement\Hidden::class,
        ]);
        $this->add([
            'name' => 'user_name',
            'type' => ZendElement\Text::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Username',
                'class' => 'form-control input-md',
                'autofocus' => true,
            ]
        ]);
        $this->add([
            'name' => 'user_first_name',
            'type' => ZendElement\Text::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'First Name',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'user_last_name',
            'type' => ZendElement\Text::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Last Name',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'user_password',
            'type' => ZendElement\Password::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Password',
                'class' => 'form-control input-md'
            ]
        ]);
        $this->add([
            'name' => 'user_email',
            'type' => ZendElement\Email::class,
            'attributes' => [
                'required' => true,
                'placeholder' => 'Email',
                'class' => 'form-control input-md',
            ]
        ]);
        $this->add([
            'name' => 'user_role',
            'type' => Element\RbacSelect::class,
            'attributes' => [
                'id' => 'role',
                'class' => 'form-control input-md',
                'required' => true,
            ]
        ]);
    }

}
