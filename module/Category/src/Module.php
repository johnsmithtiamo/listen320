<?php

namespace Category;

const TABLE_NAME = 'zf_categories';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
