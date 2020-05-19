<?php

$loader = new \Phalcon\Loader();

/**
 * Load library namespace
 */
$loader->registerNamespaces(array(

    /**
     * Load SQL server db adapter namespace
     */
    'Phalcon\Db\Adapter\Pdo' => APP_PATH . '/lib/Phalcon/Db/Adapter/Pdo',
    'Phalcon\Db\Dialect' => APP_PATH . '/lib/Phalcon/Db/Dialect',
    'Phalcon\Db\Result' => APP_PATH . '/lib/Phalcon/Db/Result',

    'Common\Interfaces' => APP_PATH . '/common/Interfaces',
    'Common\Structure' => APP_PATH . '/common/Structure',
    'Common\Utility' => APP_PATH . '/common/Utility',
    'Common\Events' => APP_PATH . '/common/Events',

    'Module\Post\Core\Application\EventSubscriber' => APP_PATH . '/modules/post/Core/Application/EventSubscriber',
    'Module\Post\Core\Domain\Interfaces' => APP_PATH . '/modules/post/Core/Domain/Interfaces',
    'Module\Post\Infrastructure\Persistence\Repository' => APP_PATH . '/modules/post/Infrastructure/Persistence/Repository',
    'Module\Post\Core\Domain\Model\Entity' => APP_PATH . '/modules/post/Core/Domain/Model/Entity',
    'Module\Post\Core\Domain\Model\Value' => APP_PATH . '/modules/post/Core/Domain/Model/Value',

));

$loader->register();
