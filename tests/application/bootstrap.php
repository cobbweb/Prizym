<?php

// Define path to application directory
defined('SRC_PATH')
    || define('SRC_PATH', realpath(__DIR__ . '/../../'));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', SRC_PATH . '/application');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'testing');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(SRC_PATH . '/lib'),
    get_include_path(),
)));

function d($var)
{
    $stack = xdebug_get_function_stack();
    $calledFrom = array_pop($stack);
    $basePath = realpath(APPLICATION_PATH . '/../');
    $file = str_replace($basePath, '', $calledFrom['file']);
    $line = $calledFrom['line'];

    $calledFrom = "Called from <strong>{$file}</strong> on <strong>line {$line}</strong>";

    require_once 'Zend/Debug.php';
    die(Zend_Debug::dump($var, $calledFrom, false));
}


require_once 'Cob/lib/Cob/Application/Application.php';

// Create application, bootstrap, and run
$application = new \Cob\Application\Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.yml'
);

$classLoader = new Doctrine\Common\ClassLoader("Tests", SRC_PATH.'/tests/application');

require_once 'EntityTestCase.php';
