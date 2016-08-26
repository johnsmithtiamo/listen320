<?php

namespace Storage\Model;

interface StorageRepositoryInterface {

    public function findAllStorages();

    public function findStorage($cat_id);
}
