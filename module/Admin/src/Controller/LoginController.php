<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\LoginForm;
use Zend\Authentication\AuthenticationService;

class LoginController extends AbstractActionController {

    protected $authService;

    const EVENT_LOGIN_SUCCESS = 'login.success';
    const EVENT_LOGIN_FAIL = 'login.fail';

    public function __construct(AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function indexAction() {
        if ($this->identity()) {
            $this->redirect()->toRoute('default', ['controller' => 'logout', 'action' => 'confirm']);
        }
        $viewmodel = new ViewModel;
        $request = $this->getRequest();
        $form = new LoginForm();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $email = $request->getPost('email', '');
                $password = $request->getPost('password', '');

                $authService = $this->getAuthService();
                $authAdapter = $authService->getAdapter();
                $authAdapter->setIdentity($email)
                        ->setCredential($password);
                $result = $authService->authenticate();
                $events = $this->getEventManager();
                if ($result->isValid()) {
                    $remember = $request->getPost('remember', 0);
                    $authService->getStorage()->setRememberMe($remember);
                    $events->trigger(self::EVENT_LOGIN_SUCCESS, null, [AuthenticationService::class => $authService]);
                    $this->redirect()->toUrl($this->getRedirectUrl());
                } else {
                    $events->trigger(self::EVENT_LOGIN_FAIL);
                }
            }
        }
        $viewmodel->setTerminal(true);
        $viewmodel->setVariable('form', $form);
        return $viewmodel;
    }

    public function getAuthService() {
        return $this->authService;
    }

    private function getRedirectUrl() {
        $redirect_url = $this->params()->fromQuery('redirect_url');
        if ($redirect_url) {
            $redirect_url = \urldecode($redirect_url);
        } else {
            $redirect_url = $this->url()->fromRoute('home', [], ['force_canonical' => true]);
        }
        return $redirect_url;
    }

}
