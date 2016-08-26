<?php

namespace Storage\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Storage\Model\StorageCommandInterface;
use Storage\Model\StorageRepositoryInterface;
use Storage\Form\StorageForm;

class EditControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(StorageForm::class);
        return new EditController($container->get(StorageCommandInterface::class), $container->get(StorageRepositoryInterface::class), $form);
    }

}
