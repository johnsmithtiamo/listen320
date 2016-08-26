<?php

namespace User\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use User\Form\UserForm;
use User\Model\UserCommandInterface;

class WriteControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new WriteController($container->get(UserCommandInterface::class), $formManager->get(UserForm::class));
    }

}
