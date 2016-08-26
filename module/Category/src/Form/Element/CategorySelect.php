<?php

namespace Category\Form\Element;

use Zend\Form\Element\Select;
use Category\Model\CategoryRepositoryInterface;

class CategorySelect extends Select {

    private $repository;

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository(CategoryRepositoryInterface $repository) {
        $this->repository = $repository;
        return $this;
    }

    public function getValueOptions() {
        if (!$this->valueOptions) {
            $categories = $this->repository->findAllCategories(1, 1000);
            $opt = [];
            $opt[0] = '-- NONE --';
            foreach ($categories as $cat) {
                /* @var $cat \Category\Model\Category */
                $opt[$cat->getCategoryId()] = $cat->getCategoryName();
            }
            $this->valueOptions = $opt;
        }
        return $this->valueOptions;
    }

}
