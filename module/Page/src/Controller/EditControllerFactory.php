<?php

namespace Page\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Page\Model\PageCommandInterface;
use Page\Model\PageRepositoryInterface;
use Page\Form\PageForm;

class EditControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(PageForm::class);
        return new EditController($container->get(PageCommandInterface::class), $container->get(PageRepositoryInterface::class), $form);
    }

}
