<?php

namespace Song\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Song\Model\SongCommandInterface;
use Song\Model\SongRepositoryInterface;

class DeleteControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new DeleteController($container->get(SongRepositoryInterface::class), $container->get(SongCommandInterface::class));
    }

}
