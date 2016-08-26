<?php

namespace Song\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Song\Form\SongForm;
use Song\Model\SongCommandInterface;

class AddControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(SongForm::class);
        return new AddController($container->get(SongCommandInterface::class), $form);
    }

}
