<?php

namespace Collection\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Collection\Model\CollectionCommandInterface;
use Collection\Model\CollectionRepositoryInterface;
use Collection\Form\CollectionForm;

class EditControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(CollectionForm::class);
        return new EditController($container->get(CollectionCommandInterface::class), $container->get(CollectionRepositoryInterface::class), $form);
    }

}
