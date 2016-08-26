<?php

namespace Collection;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Song\Model\SongCommandInterface;

return [
    'router' => [
        'routes' => [
            'collection' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/collection',
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
            Model\CollectionCommandInterface::class => Model\CollectionCommandFactory::class,
            Model\CollectionRepositoryInterface::class => Model\CollectionRepositoryFactory::class
        ],
        'delegators' => [
            SongCommandInterface::class => [
                Delegator\SongCommandDelegatorFactory::class
            ]
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\Element\CollectionMultiCheckbox::class => Form\Element\CollectionMultiCheckboxFactory::class
        ]
    ],
    'navigation' => [
        'adminmenu' => [
            'song' => [
                'pages' => [
                    [
                        'label' => 'Collections',
                        'route' => 'collection',
                        'order' => 3
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
