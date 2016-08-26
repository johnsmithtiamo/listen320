<?php

namespace Song\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\Reflection;
use Zend\Hydrator\Strategy\SerializableStrategy;
use Zend\Serializer\Adapter\PhpSerialize;

class SongRepositoryFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $hydrator = new Reflection();
        $hydrator->addStrategy('collections', new SerializableStrategy(new PhpSerialize()));
        return new SongRepository($container->get(AdapterInterface::class), $hydrator, new Song());
    }

}
