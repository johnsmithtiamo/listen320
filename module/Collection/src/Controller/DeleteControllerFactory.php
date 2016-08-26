<?php

namespace Collection\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Collection\Model\CollectionCommandInterface;
use Collection\Model\CollectionRepositoryInterface;

class DeleteControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new DeleteController($container->get(CollectionRepositoryInterface::class), $container->get(CollectionCommandInterface::class));
    }

}
