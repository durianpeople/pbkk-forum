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
    ]
);