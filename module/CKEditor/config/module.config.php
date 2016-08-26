<?php

namespace CKEditor;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_helpers' => [
        'aliases' => [
            'formCKEditor' => Form\View\Helper\FormCKEditor::class,
        ],
        'factories' => [
            Form\View\Helper\FormCKEditor::class => InvokableFactory::class
        ]
    ],
];
