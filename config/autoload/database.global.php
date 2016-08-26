<?php

return array(
    'db' => array(
        'driver' => 'Pdo_Mysql',
        'database' => 'zftutorial',
        'hostname' => 'localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
);
