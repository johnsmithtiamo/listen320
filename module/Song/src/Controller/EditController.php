<?php

namespace Song\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Song\Model\SongCommandInterface;
use Song\Form\SongForm;
use Song\Model\SongRepositoryInterface;

class EditController extends AbstractActionController {

    private $command;
    private $repository;
    private $form;

    public function __construct(SongCommandInterface $command, SongRepositoryInterface $repository, SongForm $form) {
        $this->command = $command;
        $this->repository = $repository;
        $this->form = $form;
    }

    public function indexAction() {
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('song');
        }

        try {
            $song = $this->repository->findSong($id);
            $songOld = clone $song;
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('song');
        }
        $form = $this->getForm();
        $form->bind($song);
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
        $songNew = $form->getData();
        // cập nhật bai hat
        try {
            $this->command->updateSong($songNew, $songOld);
            // thông báo thành công
            $this->flashMessenger()->addSuccessMessage('The song is updated');
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
