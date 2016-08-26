<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class LogoutController extends AbstractActionController {

    protected $authService;

    public function __construct(AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function indexAction() {
        $authService = $this->getAuthService();
        $authService->getStorage()->forgetMe();
        $authService->getStorage()->clear();
        $authService->clearIdentity();
        return $this->redirect()->toRoute('default', ['controller' => 'login']);
    }

    public function getAuthService() {
        return $this->authService;
    }

    public function confirmAction() {
        $viewModel = new ViewModel();
        $ok = $this->params()->fromQuery('ok', false);
        if ($ok !== false) {
            if ($ok) {
                return $this->redirect()->toRoute('default', ['controller' => 'logout', 'action' => 'index']);
            } else {
                return $this->redirect()->toRoute('home');
            }
        }
        $viewModel->setTerminal(TRUE);
        return $viewModel;
    }

}
