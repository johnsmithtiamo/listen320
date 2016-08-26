<?php

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Model\CollectionCommandInterface;
use Collection\Model\CollectionRepositoryInterface;
use Collection\Form\CollectionForm;

class IndexController extends AbstractActionController {

    private $repository;
    private $command;
    private $form;

    public function __construct(CollectionRepositoryInterface $repository, CollectionCommandInterface $command, CollectionForm $form) {
        $this->repository = $repository;
        $this->command = $command;
        $this->form = $form;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $page = $this->params()->fromRoute('page', 1);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            if ($this->form->isValid()) {
                $category = $this->form->getData();
                try {
                    $this->command->insertCollection($category);
                } catch (\Exception $ex) {
                    throw $ex;
                }
            }
        }
        $viewmodel->setVariable('form', $this->form);
        $viewmodel->setVariable('paginator', $this->repository->findAllCollections($page));
        return $viewmodel;
    }

}
