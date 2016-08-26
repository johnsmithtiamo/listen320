<?php

namespace Song\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Song\Model\SongRepositoryInterface;
use Song\Form\SongForm;
use Song\Model\Song;
use Zend\Hydrator\Reflection;

class ListController extends AbstractActionController {

    private $repository;
    private $form;

    public function __construct(SongRepositoryInterface $repository, SongForm $form) {
        $this->repository = $repository;
        $this->form = $form;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $page = $this->params()->fromRoute('page', 1);

        // xóa dữ liệu lọc lưu trong cookie
        $clearResult = $this->params()->fromQuery('clearResult', 'no');
        if ($clearResult === 'yes' && isset($_COOKIE['song'])) {
            unset($_COOKIE['song']);
        }

        $request = $this->getRequest();
        $paginator = null;
        $song = null;

        if ($request->isPost()) {
            $this->form->setData($request->getPost());
            // lưu trữ dữ liệu lọc vào cookie
            \setcookie('song', serialize($request->getPost('song')));
            if ($this->form->isValid()) {
                $song = $this->form->getData();
            }
        } elseif (isset($_COOKIE['song'])) {
            // lấy dữ liệu lọc từ cookie
            $song = new Song();
            $hydrator = new Reflection();
            $hydrator->hydrate(unserialize($_COOKIE['song']), $song);
        }
        if ($song) {
            $paginator = $this->repository->findWithSong($song, $page);
        }
        if (!$paginator) {
            $paginator = $this->repository->findAllSongs($page);
        }
        $viewmodel->setVariable('paginator', $paginator);
        $viewmodel->setVariable('form', $this->form);

        return $viewmodel;
    }

}
