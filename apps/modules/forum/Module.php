<?php

namespace Module\Forum;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([

            'Module\Forum\Core\Domain\Interfaces' => __DIR__ . '/Core/Domain/Interfaces',
            'Module\Forum\Core\Domain\Event' => __DIR__ . '/Core/Domain/Event',
            'Module\Forum\Core\Domain\Model\Entity' => __DIR__ . '/Core/Domain/Model/Entity',
            'Module\Forum\Core\Domain\Model\Value' => __DIR__ . '/Core/Domain/Model/Value',
            'Module\Forum\Core\Domain\Service' => __DIR__ . '/Core/Domain/Service',

            'Module\Forum\Core\Application\Request' => __DIR__ . '/Core/Application/Request',
            'Module\Forum\Core\Application\Response' => __DIR__ . '/Core/Application/Response',
            'Module\Forum\Core\Application\Interfaces' => __DIR__ . '/Core/Application/Interfaces',
            'Module\Forum\Core\Application\Service' => __DIR__ . '/Core/Application/Service',
            'Module\Forum\Core\Application\EventSubscriber' => __DIR__ . '/Core/Application/EventSubscriber',

            'Module\Forum\Core\Exception' => __DIR__ . '/Core/Exception',

            'Module\Forum\Infrastructure\Persistence\Repository' => __DIR__ . '/Infrastructure/Persistence/Repository',
            'Module\Forum\Infrastructure\Persistence\Record' => __DIR__ . '/Infrastructure/Persistence/Record',

            'Module\Forum\Presentation\Web\Controller' => __DIR__ . '/Presentation/Web/Controller',
            'Module\Forum\Presentation\Web\Validator' => __DIR__ . '/Presentation/Web/Validator',
            'Module\Forum\Presentation\Api\Controller' => __DIR__ . '/Presentation/Api/Controller',
            
        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        // Load configs
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        // Register services/dependencies
        include_once __DIR__ . '/config/services.php';

        // Run necessary scripts
        include_once __DIR__ . '/config/bootstrap.php';
    }
}