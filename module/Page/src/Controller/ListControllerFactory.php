<?php

namespace Page\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Page\Model\PageRepositoryInterface;
use Page\Form\PageForm;

class ListControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        return new ListController($container->get(PageRepositoryInterface::class), $formManager->get(PageForm::class));
    }

}
