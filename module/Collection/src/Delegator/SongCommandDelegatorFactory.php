<?php

namespace Collection\Delegator;

use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use Interop\Container\ContainerInterface;
use Collection\Listener\DefaultCollectionListener;
use Zend\Db\Adapter\AdapterInterface;

class SongCommandDelegatorFactory implements DelegatorFactoryInterface {

    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null) {
        /* @var $object \Song\Model\SongCommand */
        $object = $callback();
        $events = $object->getEventManager();
        $postCountListener = new DefaultCollectionListener();
        $postCountListener->setAdapter($container->get(AdapterInterface::class));
        $postCountListener->attach($events);
        return $object;
    }

}
