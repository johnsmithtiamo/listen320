<?php

namespace User;

use Zend\Mvc\MvcEvent;
use Admin\Controller\LoginController as Login;
use Zend\EventManager\Event;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

const TABLE_NAME = 'zf_users';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function OnBootstrap(MvcEvent $e) {
        $app = $e->getApplication();
        $events = $app->getEventManager();
        $shared = $events->getSharedManager();
        $container = $app->getServiceManager();

        // Cập nhật thời gian đăng nhập của người dùng
        $shared->attach(Login::class, Login::EVENT_LOGIN_SUCCESS, function(Event $e)use($container) {
            $adapter = $container->get(AdapterInterface::class);
            $authService = $e->getParam(AuthenticationService::class);
            $user_info = $authService->getAdapter()->getResultRowObject(['user_id', 'user_role']);
            $sql = new Sql($adapter);
            $update = $sql->update('zf_users')
                    ->set(['user_last_login' => time()])
                    ->where(['user_id' => $user_info->user_id]);
            $sql->prepareStatementForSqlObject($update)
                    ->execute();

            // lưu session phân quyền của người dùng
            $authService->getStorage()
                    ->setUserRole($user_info->user_role)
                    ->setUserId($user_info->user_id);
        });
    }

}
