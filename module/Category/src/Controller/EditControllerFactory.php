<?php

namespace Category\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Category\Model\CategoryCommandInterface;
use Category\Model\CategoryRepositoryInterface;
use Category\Form\CategoryForm;

class EditControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(CategoryForm::class);
        return new EditController($container->get(CategoryCommandInterface::class), $container->get(CategoryRepositoryInterface::class), $form);
    }

}
