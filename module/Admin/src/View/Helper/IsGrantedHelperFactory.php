<?php

namespace Admin\View\Helper;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\IsGrantedService;

class IsGrantedHelperFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $isGrantedService = $container->get(IsGrantedService::class);
        return new IsGrantedHelper($isGrantedService);
    }

}
