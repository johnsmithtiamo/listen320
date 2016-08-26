<?php

namespace Song\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Song\Model\SongCommandInterface;
use Song\Form\SongForm;

class AddController extends AbstractActionController {

    private $command;
    private $form;

    public function __construct(SongCommandInterface $command, SongForm $form) {
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
        $songData = $form->getData();
        try {
            $song = $this->command->insertSong($songData);
        } catch (\Exception $ex) {
            throw $ex;
        }
        return $this->redirect()->toRoute('song/edit', ['id' => $song->getSongId()]);
    }

}
