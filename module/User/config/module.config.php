<?php

namespace User;

use Zend\Authentication\AuthenticationService;
use User\Service\DefaultAuthenticationFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Admin\Service\RbacService;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action' => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/edit/:id',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '\d+'
                            ]
                        ],
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '\d+'
                            ]
                        ],
                    ],
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/detail/:id',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '\d+'
                            ]
                        ],
                    ],
                    'paging' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/page/:page',
                            'defaults' => [
                                'action' => 'index',
                            ],
                            'constraints' => [
                                'page' => '\d+'
                            ]
                        ],
                    ],
                ],
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            AuthenticationService::class => DefaultAuthenticationFactory::class,
            Model\UserRepositoryInterface::class => Model\UserRepositoryFactory::class,
            Model\UserCommandInterface::class => Model\UserCommandFactory::class
        ],
        'delegators' => [
            RbacService::class => [
                Delegator\RbacDelegatorFactory::class,
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\WriteController::class => Controller\WriteControllerFactory::class,
            Controller\ListController::class => Controller\ListControllerFactory::class],
    ],
    'form_elements' => [
        'factories' => [
            Form\Element\UserId::class => Form\Element\UserIdFactory::class,
        ]
    ],
    'navigation' => [
        'adminmenu' => [
            'user' => [
                'label' => 'User',
                'uri' => '#',
                'icon' => 'fa fa-user fa-fw',
                'permission' => 'user.list',
                'pages' => [
                    [
                        'label' => 'Add a new user',
                        'route' => 'user/add',
                        'permission' => 'user.add'
                    ],
                    [
                        'label' => 'List user',
                        'route' => 'user',
                        'permission' => 'user.list',
                    ],
                ],
                'order' => 100,
            ],
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
