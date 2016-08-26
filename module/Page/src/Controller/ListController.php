<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Page\Model\PageRepositoryInterface;
use Page\Form\PageForm;
use Page\Model\Page;
use Zend\Hydrator\Reflection;

class ListController extends AbstractActionController {

    private $repository;
    private $form;

    public function __construct(PageRepositoryInterface $repository, PageForm $form) {
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
            $song = new Page();
            $hydrator = new Reflection();
            $hydrator->hydrate(unserialize($_COOKIE['song']), $song);
        }
        if ($song) {
            $paginator = $this->repository->findWithPage($song, $page);
        }
        if (!$paginator) {
            $paginator = $this->repository->findAllPages($page);
        }
        $viewmodel->setVariable('paginator', $paginator);
        $viewmodel->setVariable('form', $this->form);

        return $viewmodel;
    }

}
