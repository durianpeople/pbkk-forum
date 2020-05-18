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

));

$loader->register();
