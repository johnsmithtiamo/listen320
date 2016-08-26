<?php

namespace Storage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Storage\Model\StorageRepositoryInterface;
use Storage\Model\StorageCommandInterface;

class DeleteController extends AbstractActionController {

    protected $repository;
    protected $command;

    public function __construct(StorageRepositoryInterface $repository, StorageCommandInterface $command) {
        $this->repository = $repository;
        $this->command = $command;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('category');
        }
        try {
            $storage = $this->repository->findStorage($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('category');
        }
        $confirm = $this->params()->fromQuery('confirm', false);
        $category_url = $this->url()->fromRoute('category');
        $redirect_url = $this->params()->fromQuery('redirect_url', urlencode($category_url));

        if ($confirm === 'no') {
            return $this->redirect()->toUrl(urldecode($redirect_url));
        } elseif ($confirm === 'yes') {
            try {
                $storage = $this->command->deleteStorage($storage);
            } catch (\RuntimeException $ex) {
                
            }
            return $this->redirect()->toUrl(urldecode($redirect_url));
        }

        $viewmodel->setVariable('id', $id);
        $viewmodel->setVariable('storage', $storage);
        $viewmodel->setVariable('redirect_url', $redirect_url);
        return $viewmodel;
    }

}
