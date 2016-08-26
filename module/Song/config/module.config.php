<?php

namespace Song;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'song' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/song',
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action' => 'index',
                    ],
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
                                'controller' => Controller\ListController::class,
                            ]
                        ]
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\AddController::class
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
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Controller\ListControllerFactory::class,
            Controller\AddController::class => Controller\AddControllerFactory::class,
            Controller\EditController::class => Controller\EditControllerFactory::class,
            Controller\DeleteController::class => Controller\DeleteControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            Model\SongCommandInterface::class => Model\SongCommandFactory::class,
            Model\SongRepositoryInterface::class => Model\SongRepositoryFactory::class
        ]
    ],
    'navigation' => [
        'adminmenu' => [
            'song' => [
                'label' => 'Song',
                'route' => 'song',
                'icon' => 'fa fa-music fa-fw',
                'pages' => [
                    [
                        'label' => 'Add new song',
                        'route' => 'song/add',
                        'order' => 1
                    ],
                    [
                        'label' => 'List song',
                        'route' => 'song',
                        'order' => 2
                    ],
                ],
                'order' => 5
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
