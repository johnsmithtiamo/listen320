<?php

namespace Storage;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Song\Model\SongCommandInterface;

return [
    'router' => [
        'routes' => [
            'storage' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/storage',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'paging' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/page/:page',
                            'constraints' => [
                                'page' => '\d+'
                            ],
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'constraints' => [
                                'id' => '\d+'
                            ],
                            'defaults' => [
                                'controller' => Controller\DeleteController::class,
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/edit/:id',
                            'constraints' => [
                                'id' => '\d+'
                            ],
                            'defaults' => [
                                'controller' => Controller\EditController::class,
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\EditController::class => Controller\EditControllerFactory::class,
            Controller\DeleteController::class => Controller\DeleteControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            Model\StorageCommandInterface::class => Model\StorageCommandFactory::class,
            Model\StorageRepositoryInterface::class => Model\StorageRepositoryFactory::class
        ],
        'delegators' => [
            SongCommandInterface::class => [
                Delegator\SongCommandDelegatorFactory::class
            ]
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\Element\StorageSelect::class => Form\Element\StorageSelectFactory::class
        ]
    ],
    'navigation' => [
        'adminmenu' => [
            'song' => [
                'pages' => [
                    [
                        'label' => 'Storages',
                        'route' => 'storage',
                        'order' => 4
                    ]
                ],
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
