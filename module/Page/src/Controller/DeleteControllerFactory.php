<?php

namespace Page\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Page\Model\PageCommandInterface;
use Page\Model\PageRepositoryInterface;

class DeleteControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new DeleteController($container->get(PageRepositoryInterface::class), $container->get(PageCommandInterface::class));
    }

}
