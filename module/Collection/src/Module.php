<?php

namespace Collection;

const TABLE_NAME = 'zf_collections';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
