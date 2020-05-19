<?php

use Phalcon\Mvc\Router;

$mod_config = [
    'namespace' => $module['webControllerNamespace'],
    'module' => $moduleName,
];

/** @var Router $router */

$router->add('/', array_merge($mod_config, [
    'controller' => 'index',
    'action' => 'index'
]));

$router->add('/login', array_merge($mod_config, [
    'controller' => 'login',
    'action' => 'index'
]));

$router->add('/logout', array_merge($mod_config, [
    'controller' => 'index',
    'action' => 'logout'
]));

$router->add('/register', array_merge($mod_config, [
    'controller' => 'register',
    'action' => 'index'
]));

$router->add('/forum_posts', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'index'
]));

$router->add('/post/create', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'create'
]));
