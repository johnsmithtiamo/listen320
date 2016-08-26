<?php

namespace Admin\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class IdentityListener extends AbstractListenerAggregate {

    protected $authService;
    protected $redirect_url;

    public function __construct(AuthenticationService $authService, $redirect_url = null) {
        $this->authService = $authService;
        $this->redirect_url = $redirect_url;
    }

    public function attach(EventManagerInterface $events, $priority = 1) {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], $priority);
    }

    public function onDispatch(MvcEvent $e) {
        $resultMatch = $e->getRouteMatch();
        $controllerName = $resultMatch->getParam('controller');
        if ($controllerName !== 'login' && !$this->authService->hasIdentity()) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine(
                    'Location', $e->getRouter()->assemble(['controller' => 'login'], ['name' => 'default', 'query' => ['redirect_url' => $this->redirect_url]]
                    )
            );
            $response->setStatusCode(302);
            return $response;
        }
    }

}
