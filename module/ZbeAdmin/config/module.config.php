<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AdminController' => 'ZbeAdmin\Controller\AdminController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'zbeadmin' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/zbeadmin',
                    'defaults' => array(
                        'controller'    => 'AdminController',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'dashboard' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/dashboard[/:actions]',
                            'defaults' => array(
                                'action'     => 'dashboard',
                            ),
                            'constraints' => array(
                                'actions' => '[a-zA-Z][a-zA-Z0-9_-]+'
                            )
                        ),
                    ),
                    'login' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array(
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/logout',
                            'defaults' => array(
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'layout' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/layout',
                            'defaults' => array(
                                'action'     => 'layout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZbeAdmin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'admin/layout' => __DIR__ . '/../view/layout/cleanpage.phtml',
            'admin/dashboard/layout' => __DIR__ . '/../view/layout/adminlayout.phtml',
            'zbe-admin/admin/index' => __DIR__ . '/../view/zbe-admin/index/index.phtml',
            'zbe-admin/admin/dashboard' => __DIR__ . '/../view/zbe-admin/index/dashboard.phtml',
        )
    ),
);
