<?php

namespace Page;

const TABLE_NAME = 'zf_pages';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
