<?php

namespace Category\Model;

interface CategoryCommandInterface {

    public function insertCategory(Category $cat);

    public function deleteCategory(Category $cat);

    public function updateCategory(Category $cat);
}
