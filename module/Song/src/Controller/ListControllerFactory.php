<?php

namespace Song\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Song\Model\SongRepositoryInterface;
use Song\Form\SongForm;

class ListControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new ListController($container->get(SongRepositoryInterface::class), $formManager->get(SongForm::class));
    }

}
