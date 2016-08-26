<?php

namespace Storage\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Storage\Model\StorageCommandInterface;
use Storage\Model\StorageRepositoryInterface;

class DeleteControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new DeleteController($container->get(StorageRepositoryInterface::class), $container->get(StorageCommandInterface::class));
    }

}
