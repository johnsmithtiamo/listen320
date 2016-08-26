<?php

namespace Admin\Service;

use Zend\Permissions\Rbac\Rbac;

class IsGrantedService {

    protected $rbacService;
    protected $role;

    public function __construct($role, Rbac $rbacService) {
        $this->rbacService = $rbacService;
        $this->role = $role;
    }

    public function isGranted($permission, $assert = null) {
        return $this->rbacService->isGranted($this->role, $permission, $assert);
    }

}
