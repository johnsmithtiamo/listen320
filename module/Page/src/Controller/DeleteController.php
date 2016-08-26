<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\PageCommandInterface;
use Page\Model\PageRepositoryInterface;

class DeleteController extends AbstractActionController {

    protected $repository;
    protected $command;

    public function __construct(PageRepositoryInterface $repository, PageCommandInterface $command) {
        $this->repository = $repository;
        $this->command = $command;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('song');
        }
        try {
            $page = $this->repository->findPage($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('song');
        }
        $confirm = $this->params()->fromQuery('confirm', false);
        $page_url = $this->url()->fromRoute('song');
        $redirect_url = $this->params()->fromQuery('redirect_url', urlencode($page_url));

        if ($confirm === 'no') {
            return $this->redirect()->toUrl(urldecode($redirect_url));
        } elseif ($confirm === 'yes') {
            try {
                $page = $this->command->deletePage($page);
            } catch (\RuntimeException $ex) {
                
            }
            return $this->redirect()->toUrl(urldecode($redirect_url));
        }

        $viewmodel->setVariable('id', $id);
        $viewmodel->setVariable('page', $page);
        $viewmodel->setVariable('redirect_url', $redirect_url);
        return $viewmodel;
    }

}
