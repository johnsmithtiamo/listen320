<?php

namespace Song\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Song\Model\SongCommandInterface;
use Song\Model\SongRepositoryInterface;

class DeleteController extends AbstractActionController {

    protected $repository;
    protected $command;

    public function __construct(SongRepositoryInterface $repository, SongCommandInterface $command) {
        $this->repository = $repository;
        $this->command = $command;
    }

    public function indexAction() {
        $viewmodel = new ViewModel;
        $id = $this->params()->fromRoute('id');
        if (!$id) {
            return $this->redirect()->toRoute('song');
        }
        try {
            $song = $this->repository->findSong($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('song');
        }
        $confirm = $this->params()->fromQuery('confirm', false);
        $song_url = $this->url()->fromRoute('song');
        $redirect_url = $this->params()->fromQuery('redirect_url', urlencode($song_url));

        if ($confirm === 'no') {
            return $this->redirect()->toUrl(urldecode($redirect_url));
        } elseif ($confirm === 'yes') {
            try {
                $song = $this->command->deleteSong($song);
            } catch (\RuntimeException $ex) {
                
            }
            return $this->redirect()->toUrl(urldecode($redirect_url));
        }

        $viewmodel->setVariable('id', $id);
        $viewmodel->setVariable('song', $song);
        $viewmodel->setVariable('redirect_url', $redirect_url);
        return $viewmodel;
    }

}
