<?php

namespace Admin\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\RbacService;

class RbacServiceFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $rbac = new RbacService();
        $rbac->addRole('Super Admin');
        $rbac->addRole('Administrator', 'Super Admin');
        $rbac->addRole('Editor', 'Administrator');
        $rbac->addRole('Author', 'Editor');
        $rbac->addRole('Contributor', 'Author');
        $rbac->addRole('Subscriber', 'Contributor');
        return $rbac;
    }

}
