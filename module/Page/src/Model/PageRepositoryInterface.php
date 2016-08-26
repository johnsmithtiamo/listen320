<?php

namespace Page\Model;

interface PageRepositoryInterface {

    public function findAllPages();

    public function findPage($song_id);
}
