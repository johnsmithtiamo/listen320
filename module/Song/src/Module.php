<?php

namespace Song;

const TABLE_NAME = 'zf_songs';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
