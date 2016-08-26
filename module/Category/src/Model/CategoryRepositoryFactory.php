<?php

namespace Category\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\Reflection;

class CategoryRepositoryFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new CategoryRepository($container->get(AdapterInterface::class), new Reflection, new Category);
    }

}
