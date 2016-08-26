<?php

namespace Collection\Model;

interface CollectionCommandInterface {

    public function insertCollection(Collection $collection);

    public function deleteCollection(Collection $collection);

    public function updateCollection(Collection $collection);
}
