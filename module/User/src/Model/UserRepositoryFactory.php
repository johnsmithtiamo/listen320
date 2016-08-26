<?php

namespace User\Model;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\Reflection as ReflectionHydrator;

class UserRepositoryFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $reflectionHydrator = new ReflectionHydrator();
        $reflectionHydrator->addFilter('prefix_properties', function($p) {
            if (strpos($p, 'user_') === 0) {
                return true;
            } else {
                return false;
            }
        });
        return new UserRepository($container->get(AdapterInterface::class), $reflectionHydrator, new User);
    }

}
