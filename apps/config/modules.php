<?php

return array(
    'forum' => [
        'namespace' => 'Module\Forum',
        'webControllerNamespace' => 'Module\Forum\Presentation\Web\Controller',
        'apiControllerNamespace' => '',
        'className' => 'Module\Forum\Module',
        'path' => APP_PATH . '/modules/Forum/Module.php',
        'defaultRouting' => false,
        'defaultController' => 'index',
        'defaultAction' => 'index'
    ],
    'post' => [
        'namespace' => 'Module\Post',
        'webControllerNamespace' => 'Module\Post\Presentation\Web\Controller',
        'apiControllerNamespace' => '',
        'className' => 'Module\Post\Module',
        'path' => APP_PATH . '/modules/post/Module.php',
        'defaultRouting' => false,
        'defaultController' => 'index',
        'defaultAction' => 'index'
    ],
    'integration' => [
        'namespace' => 'Module\Integration',
        'webControllerNamespace' => 'Module\Integration\Presentation\Web\Controller',
        'apiControllerNamespace' => '',
        'className' => 'Module\Integration\Module',
        'path' => APP_PATH . '/modules/integration/Module.php',
        'defaultRouting' => false,
        'defaultController' => 'index',
        'defaultAction' => 'index'
    ],
);
