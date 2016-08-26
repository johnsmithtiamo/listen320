<?php

namespace Storage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Storage\Model\StorageCommandInterface;
use Storage\Model\StorageRepositoryInterface;
use Storage\Form\StorageForm;

class IndexController extends AbstractActionController {

    private $repository;
    private $command;
    private $form;

    public function __construct(StorageRepositoryInterface $repository, StorageCommandInterface $command, StorageForm $form) {
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
                    $this->command->insertStorage($category);
                } catch (\Exception $ex) {
                    throw $ex;
                }
            }
        }
        $viewmodel->setVariable('form', $this->form);
        $viewmodel->setVariable('paginator', $this->repository->findAllStorages($page));
        return $viewmodel;
    }

}
