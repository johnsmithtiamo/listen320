<?php

namespace Admin\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Admin\Service\RbacService;

class IsGrantedServiceFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $role = $container->get(AuthenticationService::class)->getStorage()->getUserRole();
        $rbacService = $container->get(RbacService::class);
        return new IsGrantedService($role, $rbacService);
    }

}
