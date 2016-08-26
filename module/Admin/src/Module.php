<?php

namespace Admin;

use Zend\Mvc\MvcEvent;
use Admin\Controller\LoginController as Login;
use Zend\EventManager\Event;
use Zend\Authentication\AuthenticationService;

class Module {

    const VERSION = '3.0.0dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e) {
        $app = $e->getApplication();
        $events = $app->getEventManager();
        $container = $app->getServiceManager();

        $identityListener = $container->get(Listener\IdentityListener::class);
        $identityListener->attach($events);
        $shared = $events->getSharedManager();
    }

}
