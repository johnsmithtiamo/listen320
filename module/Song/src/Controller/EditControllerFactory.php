<?php

namespace Song\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Song\Model\SongCommandInterface;
use Song\Model\SongRepositoryInterface;
use Song\Form\SongForm;

class EditControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(SongForm::class);
        return new EditController($container->get(SongCommandInterface::class), $container->get(SongRepositoryInterface::class), $form);
    }

}
