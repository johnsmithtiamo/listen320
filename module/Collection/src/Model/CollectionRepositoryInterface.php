<?php

namespace Collection\Model;

interface CollectionRepositoryInterface {

    public function findAllCollections();

    public function findCollection($cat_id);
}
