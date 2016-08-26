<?php

namespace Admin\Form\Element;

use Zend\Form\Element\Select;
use Admin\Service\RbacService;

class RbacSelect extends Select {

    public function __construct(RbacService $rbacService, $name = null, $options = array()) {
        parent::__construct($name, $options);
        // create iterator

        $iterator = new \RecursiveIteratorIterator(
                $rbacService, \RecursiveIteratorIterator::SELF_FIRST
        );
        $opts = [];
        foreach ($iterator as $role) {
            /* @var $role \Zend\Permissions\Rbac\Role */
            $opts[$role->getName()] = $role->getName();
        }
        $this->valueOptions = $opts;
    }

}
