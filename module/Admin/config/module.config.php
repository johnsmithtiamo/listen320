<?php

namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'default' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/:controller[/:action]',
                    'defaults' => [
                        'action' => 'index'
                    ]
                ]
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'adminmenu' => [
            [
                'label' => 'Dashboard',
                'route' => 'home',
                'icon' => 'fa fa-dashboard fa-fw',
                'order' => 0,
            ]
        ]
    ],
    'controllers' => [
        'aliases' => [
            'login' => Controller\LoginController::class,
            'logout' => Controller\LogoutController::class,
        ],
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\LoginController::class => Controller\LoginControllerFactory::class,
            Controller\LogoutController::class => Controller\LogoutControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\Element\RbacSelect::class => Form\Element\RbacSelectFactory::class
        ]
    ],
    'controller_plugins' => [
        'aliases' => [
            'isGranted' => Controller\Plugin\IsGrantedPlugin::class,
        ],
        'factories' => [
            Controller\Plugin\IsGrantedPlugin::class => Controller\Plugin\IsGrantedPluginFactory::class
        ]
    ],
    'view_helpers' => [
        'aliases' => [
            'isGranted' => View\Helper\IsGrantedHelper::class,
        ],
        'factories' => [
            View\Helper\IsGrantedHelper::class => View\Helper\IsGrantedHelperFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            Listener\IdentityListener::class => Listener\IdentityListenerFactory::class,
            Service\RbacService::class => Service\RbacServiceFactory::class,
            Service\IsGrantedService::class => Service\IsGrantedServiceFactory::class
        ],
    ],
    'view_manager' => [
        'base_path' => '/public',
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/header' => __DIR__ . '/../view/layout/header.phtml',
            'layout/footer' => __DIR__ . '/../view/layout/footer.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
