<?php

namespace Category\Form\Element;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Category\Model\CategoryRepositoryInterface;

class CategorySelectFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $categorySelect = new CategorySelect;
        $categorySelect->setRepository($container->get(CategoryRepositoryInterface::class));
        return $categorySelect;
    }

}
