<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;

class IndexController extends AbstractActionController {

    protected $form;

    public function __construct($form) {
        $this->form = $form;
    }

    public function indexAction() {
        if (!$this->isGranted('user.list')) {
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel();
    }

    public function addAction() {
        if (!$this->isGranted('user.add')) {
            return $this->redirect()->toRoute('home');
        }
        /* @var $a \Zend\Permissions\Rbac\Rbac */

        $form = $this->form;
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        return $this->redirect()->toRoute('user/edit', ['id' => '???']);
    }

    public function editAction() {

        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        try {
            $post = $this->repository->findPost($id);
        } catch (InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('blog');
        }

        $this->form->bind($post);
        $viewModel = new ViewModel(['form' => $this->form]);

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if (!$this->form->isValid()) {
            return $viewModel;
        }

        $post = $this->command->updatePost($post);
        return $this->redirect()->toRoute(
                        'blog/detail', ['id' => $post->getId()]
        );
    }

}
