<?php

namespace Collection\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Collection\Model\CollectionCommandInterface;
use Collection\Model\CollectionRepositoryInterface;
use Collection\Form\CollectionForm;

class IndexControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new IndexController($container->get(CollectionRepositoryInterface::class), $container->get(CollectionCommandInterface::class), $formManager->get(CollectionForm::class));
    }

}
