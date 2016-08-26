<?php

namespace Storage\Model;

interface StorageCommandInterface {

    public function insertStorage(Storage $storage);

    public function deleteStorage(Storage $storage);

    public function updateStorage(Storage $storage);
}
