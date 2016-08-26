<?php

namespace Search;

const TABLE_NAME = 'zf_search';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
