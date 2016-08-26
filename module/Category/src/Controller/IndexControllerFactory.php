<?php

namespace Category\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Category\Model\CategoryCommandInterface;
use Category\Model\CategoryRepositoryInterface;
use Category\Form\CategoryForm;

class IndexControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new IndexController($container->get(CategoryRepositoryInterface::class), $container->get(CategoryCommandInterface::class), $formManager->get(CategoryForm::class));
    }

}
