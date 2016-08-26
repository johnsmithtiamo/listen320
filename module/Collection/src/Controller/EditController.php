<?php

namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Collection\Model\CollectionCommandInterface;
use Collection\Form\CollectionForm;
use Collection\Model\CollectionRepositoryInterface;

class EditController extends AbstractActionController {

    private $command;
    private $repository;
    private $form;

    public function __construct(CollectionCommandInterface $command, CollectionRepositoryInterface $repository, CollectionForm $form) {
        $this->command = $command;
        $this->repository = $repository;
        $this->form = $form;
    }

    public function indexAction() {
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('collection');
        }

        try {
            $collectionOld = $this->repository->findCollection($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('collection');
        }

        $form = $this->getForm();
        $form->bind($collectionOld);
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
        $collectionNew = $form->getData();
        // cập nhật chuyên mục
        try {
            $this->command->updateCollection($collectionNew);
            // thông báo thành công
            $this->flashMessenger()->addSuccessMessage('The collection is updated');
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
