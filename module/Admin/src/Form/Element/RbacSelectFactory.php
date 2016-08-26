<?php

namespace Admin\Form\Element;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\RbacService;

class RbacSelectFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $rbacService = $container->get(RbacService::class);
        return new RbacSelect($rbacService);
    }

}
