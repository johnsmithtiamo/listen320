<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use User\Model\UserCommandInterface;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController {

    protected $form;
    protected $command;
    protected $validate;

    public function __construct(UserCommandInterface $userCommand, Form $form) {
        $this->command = $userCommand;
        $this->form = $form;
    }

    /**
     *
     * @return Form
     */
    public function getForm() {
        return $this->form;
    }

    public function addAction() {
        if (!$this->isGranted('user.add')) {
            return $this->redirect()->toRoute('home');
        }
        $form = $this->getForm();
        $request = $this->getRequest();

        $viewModel = new ViewModel(['form' => $form]);

        if (!$request->isPost()) {
            return $viewModel;
        }
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewModel;
        }
        $user = $form->getData();
        try {
            if ($this->command->exists($user)) {
                $viewModel->setVariable('userExists', 'Username or Useremail is exists');
                return $viewModel;
            }
            $userLastInsert = $this->command->insertUser($user);
        } catch (\Exception $ex) {
            throw $ex;
        }
        return $this->redirect()->toRoute('user/edit', ['id' => $userLastInsert]);
    }

}
