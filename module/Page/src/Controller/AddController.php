<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\PageCommandInterface;
use Page\Form\PageForm;

class AddController extends AbstractActionController {

    private $command;
    private $form;

    public function __construct(PageCommandInterface $command, PageForm $form) {
        $this->command = $command;
        $this->form = $form;
    }

    public function getForm() {
        return $this->form;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $form = $this->getForm();
        $request = $this->getRequest();
        $viewmodel->setVariable('form', $form);
        if (!$request->isPost()) {
            return $viewmodel;
        }
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $viewmodel;
        }
        $pageData = $form->getData();
        try {
            $page = $this->command->insertPage($pageData);
        } catch (\Exception $ex) {
            throw $ex;
        }
        return $this->redirect()->toRoute('page/edit', ['id' => $page->getPageId()]);
    }

}
