<?php

namespace Category\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Category\Model\CategoryCommandInterface;
use Category\Model\CategoryRepositoryInterface;

class DeleteControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new DeleteController($container->get(CategoryRepositoryInterface::class), $container->get(CategoryCommandInterface::class));
    }

}
