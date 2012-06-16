<?php

$root = dirname(dirname(__DIR__));

$config = array(
    /* Required */

    // The directory where PEAR is located
    'pear_path'      => '/usr/share/pear',

    // The directory where the tests reside
    'test_directory' => '/srv/http/pu/app/',


    /* Optional */

    // Whether or not to store the statistics in a database
    // (these statistics will be used to generate graphs)
    'store_statistics' => false,

    // The database configuration
    'db' => array(
        // MySQL is currently the only database supported
        // (do not change this)
        'plugin'   => '\app\lib\PDO_MySQL',

        'database' => 'vpu',
        'host'     => 'localhost',
        'port'     => '3306',
        'username' => 'root',
        'password' => 'admin'
    ),

    // Whether or not to create snapshots of the test results
    'create_snapshots' => false,

    // The directory where the test results will be stored
    'snapshot_directory' => $root . '/app/history/',

    // Whether or not to sandbox PHP errors
    'sandbox_errors' => false,

    // Which errors to sandbox
    //
    // (note that E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING,
    // E_COMPILE_ERROR, E_COMPILE_WARNING, and most of E_STRICT cannot
    // be sandboxed)
    //
    // see the following for more information:
    // http://us3.php.net/manual/en/errorfunc.constants.php
    // http://us3.php.net/manual/en/function.error-reporting.php
    // http://us3.php.net/set_error_handler
    'error_reporting' => E_ALL | E_STRICT,

    // The PHPUnit XML configuration file to use
    // (set to false to disable)
    'xml_configuration_file' => false,
    //'xml_configuration_file' => $root . '/app/config/phpunit.xml',

    // Paths to any necessary bootstraps
    'bootstraps' => array(
        // '/path/to/bootstrap.php'
    )
);


set_include_path(
    get_include_path()
    . PATH_SEPARATOR . $root
    . PATH_SEPARATOR . $config['pear_path']
);

foreach ( $config['bootstraps'] as $bootstrap ) {
    require $bootstrap;
}

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Util/Log/JSON.php';

spl_autoload_register(function($class) {
    $file = str_replace('\\', '/', $class) . '.php';
    require $file;
});

\app\lib\Library::store($config);

?>