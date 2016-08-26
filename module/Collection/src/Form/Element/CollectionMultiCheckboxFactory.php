<?php

namespace Collection\Form\Element;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Collection\Model\CollectionRepositoryInterface;

class CollectionMultiCheckboxFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $collectionMultiCheckbox = new CollectionMultiCheckbox;
        $collectionMultiCheckbox->setRepository($container->get(CollectionRepositoryInterface::class));
        return $collectionMultiCheckbox;
    }

}
