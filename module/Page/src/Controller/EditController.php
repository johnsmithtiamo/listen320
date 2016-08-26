<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\PageCommandInterface;
use Page\Form\PageForm;
use Page\Model\PageRepositoryInterface;

class EditController extends AbstractActionController {

    private $command;
    private $repository;
    private $form;

    public function __construct(PageCommandInterface $command, PageRepositoryInterface $repository, PageForm $form) {
        $this->command = $command;
        $this->repository = $repository;
        $this->form = $form;
    }

    public function indexAction() {
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('page');
        }

        try {
            $page = $this->repository->findPage($id);
            $pageOld = clone $page;
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('page');
        }
        $form = $this->getForm();
        $form->bind($page);
        $viewModel = new ViewModel(['form' => $this->form, 'id' => $id]);

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $viewModel;
        }

        $form->setData($request->getPost());

        // kiểm tra dữ liệu hợp lệ từ form
        if (!$form->isValid()) {
            return $viewModel;
        }
        $pageNew = $form->getData();
        // cập nhật bai hat
        try {
            $this->command->updatePage($pageNew, $pageOld);
            // thông báo thành công
            $this->flashMessenger()->addSuccessMessage('The page is updated');
        } catch (\RuntimeException $exc) {
            // thông báo có lỗi
            $this->flashMessenger()->addErrorMessage($exc->getMessage());
        }
        return $viewModel;
    }

    public function getForm() {
        return $this->form;
    }

}
