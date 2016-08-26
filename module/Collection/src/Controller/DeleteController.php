<?php

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Model\CollectionRepositoryInterface;
use Collection\Model\CollectionCommandInterface;

class DeleteController extends AbstractActionController {

    protected $repository;
    protected $command;

    public function __construct(CollectionRepositoryInterface $repository, CollectionCommandInterface $command) {
        $this->repository = $repository;
        $this->command = $command;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('collection');
        }
        try {
            $collection = $this->repository->findCollection($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('collection');
        }
        $confirm = $this->params()->fromQuery('confirm', false);
        $collection_url = $this->url()->fromRoute('collection');
        $redirect_url = $this->params()->fromQuery('redirect_url', urlencode($collection_url));

        if ($confirm === 'no') {
            return $this->redirect()->toUrl(urldecode($redirect_url));
        } elseif ($confirm === 'yes') {
            try {
                $collection = $this->command->deleteCollection($collection);
            } catch (\RuntimeException $ex) {
                
            }
            return $this->redirect()->toUrl(urldecode($redirect_url));
        }

        $viewmodel->setVariable('id', $id);
        $viewmodel->setVariable('collection', $collection);
        $viewmodel->setVariable('redirect_url', $redirect_url);
        return $viewmodel;
    }

}
