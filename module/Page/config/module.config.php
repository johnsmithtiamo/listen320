<?php

namespace Page;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'page' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/page',
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
            Model\PageCommandInterface::class => Model\PageCommandFactory::class,
            Model\PageRepositoryInterface::class => Model\PageRepositoryFactory::class
        ]
    ],
    'navigation' => [
        'adminmenu' => [
            'page' => [
                'label' => 'Page',
                'route' => 'page',
                'icon' => 'fa fa-file fa-fw',
                'pages' => [
                    [
                        'label' => 'Add new page',
                        'route' => 'page/add',
                        'order' => 1
                    ],
                    [
                        'label' => 'List page',
                        'route' => 'page',
                        'order' => 2
                    ],
                ],
                'order' => 6
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
