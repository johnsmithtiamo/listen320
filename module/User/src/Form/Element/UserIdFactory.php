<?php

namespace User\Form\Element;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class UserIdFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $userIdElement = new UserId;
        $user_id = $container->get(AuthenticationService::class)->getStorage()->getUserId();
        $userIdElement->setValue($user_id);
        return $userIdElement;
    }

}
