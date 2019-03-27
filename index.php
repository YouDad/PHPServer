<?php
/**
 * Entrance File
 * 1.Define Constants
 * 2.Load Function Library
 * 3.Start-Up Framework
 */

define('IMOOC', realpath('.') . '/');
define('CORE', IMOOC . 'core/');
define('APP', IMOOC . 'app/');
define('CTRL', APP . 'ctrl/');

define('DEBUG', true);

if (DEBUG) {
    ini_set('display_error', 'On');
} else {
    ini_set('display_error', 'Off');
}

include CORE . 'common/function.php';
include CORE . 'imooc.php';

# next line will specify imooc::load
# be called when class is not be loaded
spl_autoload_register('\core\imooc::load');

\core\imooc::run();

