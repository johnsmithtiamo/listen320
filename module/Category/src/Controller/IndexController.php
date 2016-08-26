<?php

namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Category\Model\CategoryCommandInterface;
use Category\Model\CategoryRepositoryInterface;
use Category\Form\CategoryForm;

class IndexController extends AbstractActionController {

    private $repository;
    private $command;
    private $form;

    public function __construct(CategoryRepositoryInterface $repository, CategoryCommandInterface $command, CategoryForm $form) {
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
                    $this->command->insertCategory($category);
                } catch (\Exception $ex) {
                    throw $ex;
                }
            }
        }
        $viewmodel->setVariable('form', $this->form);
        $viewmodel->setVariable('paginator', $this->repository->findAllCategories($page));
        return $viewmodel;
    }

}
