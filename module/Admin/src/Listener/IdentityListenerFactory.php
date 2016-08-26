<?php

namespace Admin\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class IdentityListenerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authService = $container->get(AuthenticationService::class);
        $serverUrl = $container->get('ViewHelperManager')->get('serverUrl');
        return new IdentityListener($authService, urlencode($serverUrl(true)));
    }

}
