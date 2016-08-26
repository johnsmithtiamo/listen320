<?php

namespace Category\Model;

interface CategoryRepositoryInterface {

    public function findAllCategories();

    public function findCategory($cat_id);
}
