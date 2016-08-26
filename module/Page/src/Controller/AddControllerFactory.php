<?php

namespace Page\Controller;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Page\Form\PageForm;
use Page\Model\PageCommandInterface;

class AddControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $formManager = $container->get('FormElementManager');
        $form = $formManager->get(PageForm::class);
        return new AddController($container->get(PageCommandInterface::class), $form);
    }

}
