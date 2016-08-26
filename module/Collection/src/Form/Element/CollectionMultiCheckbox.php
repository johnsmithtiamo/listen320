<?php

namespace Collection\Form\Element;

use Zend\Form\Element\MultiCheckbox;
use Collection\Model\CollectionRepositoryInterface;

class CollectionMultiCheckbox extends MultiCheckbox {

    private $repository;

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository(CollectionRepositoryInterface $repository) {
        $this->repository = $repository;
        return $this;
    }

    public function getValueOptions() {
        if (!$this->valueOptions) {
            $categories = $this->repository->findAllCollections(1, 1000);
            $opt = [];
            foreach ($categories as $cat) {
                /* @var $cat \Collection\Model\Collection */
                $opt[$cat->getCollectionId()] = $cat->getCollectionName();
            }
            $this->valueOptions = $opt;
        }
        return $this->valueOptions;
    }

}
