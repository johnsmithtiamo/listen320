<?php

namespace Song\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Song\Listener\DefaultSongCommandListener;

class SongCommandFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $events = $container->get('EventManager');
        $defaultSongCommandListener = new DefaultSongCommandListener;
        $defaultSongCommandListener->attach($events);
        return new SongCommand($container->get(AdapterInterface::class), $events);
    }

}
