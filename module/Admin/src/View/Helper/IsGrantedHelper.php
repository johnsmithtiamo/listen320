<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Admin\Service\IsGrantedService;

class IsGrantedHelper extends AbstractHelper {

    protected $isGrantedService;

    public function __construct(IsGrantedService $isGrantedService) {
        $this->isGrantedService = $isGrantedService;
    }

    public function __invoke($permission, $assert = null) {
        return $this->isGrantedService->isGranted($permission, $assert);
    }

}
