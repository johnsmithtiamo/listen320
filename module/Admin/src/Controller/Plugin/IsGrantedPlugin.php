<?php

namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Admin\Service\IsGrantedService;

class IsGrantedPlugin extends AbstractPlugin {

    protected $isGrantedService;

    public function __construct(IsGrantedService $isGrantedService) {
        $this->isGrantedService = $isGrantedService;
    }

    public function __invoke($permission, $assert = null) {
        return $this->isGrantedService->isGranted($permission, $assert);
    }

}
