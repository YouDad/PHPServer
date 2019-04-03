<?php
/**
 * Entrance File
 * 1.Define Constants
 * 2.Load Function Library
 * 3.Start-Up Framework
 */
header("Access-Control-Allow-Origin:*");
define('APIS', realpath('.') . '/');
define('CORE', APIS . 'core/');
define('APP', APIS . 'app/');
define('CTRL', APIS . 'ctrl/');
define('DEBUG', true);

include 'vendor/autoload.php';

if (DEBUG) {
    # load whoops
    $whoops = new \Whoops\Run;
    $errorTitle = 'Framework occurs error!';
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($errorTitle);
    $whoops->pushHandler($option);
    $whoops->register();

    ini_set('display_error', 'On');
} else {
    ini_set('display_error', 'Off');
}

include CORE . 'Apis.php';
include 'common/includer.php';

# next line will specify Apis::load
# be called when class is not be loaded
spl_autoload_register('\core\Apis::load');

\core\Apis::run();

function model($name){
    $className = "\\core\\lib\\model\\".$name."Model";
    return $className::getIns();
}