<?php

namespace Storage;

const TABLE_NAME = 'zf_storages';

class Module {

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
