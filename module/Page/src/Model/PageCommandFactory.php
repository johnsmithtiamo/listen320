<?php

namespace Page\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Page\Listener\DefaultPageCommandListener;

class PageCommandFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $events = $container->get('EventManager');
        $defaultPageCommandListener = new DefaultPageCommandListener;
        $defaultPageCommandListener->attach($events);
        return new PageCommand($container->get(AdapterInterface::class), $events);
    }

}
