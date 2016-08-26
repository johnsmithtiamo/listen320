<?php

namespace Storage\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Storage\Model\StorageCommandInterface;
use Storage\Model\StorageRepositoryInterface;
use Storage\Form\StorageForm;

class IndexControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new IndexController($container->get(StorageRepositoryInterface::class), $container->get(StorageCommandInterface::class), $formManager->get(StorageForm::class));
    }

}
