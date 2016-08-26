<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Model\UserRepositoryInterface;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController {

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepoInterface) {
        $this->userRepository = $userRepoInterface;
    }

    public function detailAction() {
        $user_id = $this->params()->fromRoute('id');

        try {
            $user = $this->userRepository->findPost($user_id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('user');
        }

        return new ViewModel([
            'user' => $user,
        ]);
    }

}
