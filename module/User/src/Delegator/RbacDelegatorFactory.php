<?php

namespace User\Delegator;

use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use Interop\Container\ContainerInterface;

class RbacDelegatorFactory implements DelegatorFactoryInterface {

    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null) {
        /* @var $rbac \Zend\Permissions\Rbac\Rbac */
        $rbac = call_user_func($callback);
        /* @var $role \Zend\Permissions\Rbac\Role */
        $role = $rbac->getRole('Administrator');
        $role->addPermission('user.list')
                ->addPermission('user.add');
        return $rbac;
    }

}
