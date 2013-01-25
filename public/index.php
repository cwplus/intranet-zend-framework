<?php

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library'),
            realpath(APPLICATION_PATH . '/models'),
            get_include_path(),
        )));


/*
 * DEBUT - SOURCE : http://framework.zend.com/wiki/display/ZFDEV/Official+ZF+QuickStart+Draft
 */

// Step 1: Enable all errors so we'll know when something goes wrong.
error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

// Step 2: Add our {{library}} directory to the include path so that PHP can find the Zend Framework classes.
//set_include_path('../library' . PATH_SEPARATOR . get_include_path()); 
// Step 3: Set up autoload.
// This is a nifty trick that allows ZF to load classes automatically so that you don't have to litter your
// code with 'include' or 'require' statements.
require_once "Zend/Loader/Autoloader.php";
//        Zend_Loader::registerAutoload();
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Mick_');
$autoloader->setFallbackAutoloader(true);

// Step 4: Get the front controller.
// The Zend_Front_Controller class implements the Singleton pattern, which is a design pattern used to ensure
// there is only one instance of Zend_Front_Controller created on each request.
$frontController = Zend_Controller_Front::getInstance();

// Step 5: Disable error handler. We'd like to see all the errors we enabled in Step 1. :)
$frontController->throwExceptions(true);

// Step 6: Point the front controller to your action controller directory.
$frontController->setControllerDirectory('../application/controllers');

// Step 7:  Dispatch the request using the front controller.
//$frontController->dispatch();

/*
 * FIN - SOURCE : http://framework.zend.com/wiki/display/ZFDEV/Official+ZF+QuickStart+Draft
 */





/** Zend_Application */
require_once 'Zend/Application.php';

$classFileIncCache = APPLICATION_PATH . '/../cache/pluginLoaderCache.php';
if (file_exists($classFileIncCache)) {
    include_once $classFileIncCache;
}

// AUTH / ACL
Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
$front = Zend_Controller_Front::getInstance();
$acl_ini = APPLICATION_PATH.'/configs/acl.ini' ;  
$acl     = new Mick_Acl_Ini($acl_ini) ;
$front->registerPlugin(new Mick_Plugin_Authentification($acl));

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();