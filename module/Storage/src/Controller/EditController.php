<?php

namespace Storage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Storage\Model\StorageCommandInterface;
use Storage\Form\StorageForm;
use Storage\Model\StorageRepositoryInterface;

class EditController extends AbstractActionController {

    private $command;
    private $repository;
    private $form;

    public function __construct(StorageCommandInterface $command, StorageRepositoryInterface $repository, StorageForm $form) {
        $this->command = $command;
        $this->repository = $repository;
        $this->form = $form;
    }

    public function indexAction() {
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('category');
        }

        try {
            $categoryOld = $this->repository->findStorage($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('category');
        }

        $form = $this->getForm();
        $form->bind($categoryOld);
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
        $categoryNew = $form->getData();
        // cập nhật chuyên mục
        try {
            $this->command->updateStorage($categoryNew);
            // thông báo thành công
            $this->flashMessenger()->addSuccessMessage('The category is updated');
        } catch (\RuntimeException $exc) {
            // thông báo có lỗi
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }
        return $viewModel;
    }

    public function getForm() {
        return $this->form;
    }

}
