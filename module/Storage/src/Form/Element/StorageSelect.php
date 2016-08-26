<?php

namespace Storage\Form\Element;

use Zend\Form\Element\Select;
use Storage\Model\StorageRepositoryInterface;

class StorageSelect extends Select {

    private $repository;

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository(StorageRepositoryInterface $repository) {
        $this->repository = $repository;
        return $this;
    }

    public function getValueOptions() {
        if (!$this->valueOptions) {
            $categories = $this->repository->findAllStorages(1, 1000);
            $opt = [];
            $opt[0] = '-- NONE --';
            foreach ($categories as $cat) {
                /* @var $cat \Storage\Model\Storage */
                $opt[$cat->getStorageId()] = $cat->getStorageName();
            }
            $this->valueOptions = $opt;
        }
        return $this->valueOptions;
    }

}
