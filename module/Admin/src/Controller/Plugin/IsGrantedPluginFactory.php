<?php

namespace Admin\Controller\Plugin;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\IsGrantedService;

class IsGrantedPluginFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $isGrantedService = $container->get(IsGrantedService::class);
        return new IsGrantedPlugin($isGrantedService);
    }

}
