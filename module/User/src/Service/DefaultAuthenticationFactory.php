<?php

namespace User\Service;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Zend\Db\Adapter\AdapterInterface;
use User\Storage\SessionLoginStorage;

class DefaultAuthenticationFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $authService = new AuthenticationService();
        $zendDb = $container->get(AdapterInterface::class);

        $adapter = new CredentialTreatmentAdapter($zendDb, 'zf_users', 'user_email', 'user_password', 'MD5(?) AND user_active = 1');
        $authService->setAdapter($adapter);

        $authStorage = new SessionLoginStorage();
        $authService->setStorage($authStorage);
        return $authService;
    }

}
