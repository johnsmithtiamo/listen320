<?php

namespace Storage\Form\Element;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Storage\Model\StorageRepositoryInterface;

class StorageSelectFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $categorySelect = new StorageSelect;
        $categorySelect->setRepository($container->get(StorageRepositoryInterface::class));
        return $categorySelect;
    }

}
