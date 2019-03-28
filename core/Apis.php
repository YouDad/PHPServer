<?php

namespace core;
use core\lib as lib;

class Apis
{
    public static $classMap = array();

    public static function run()
    {
        # init log.
        lib\log::init();
        # load ctrl, respond request.
        $route = new lib\route();
        $ctrlClass = $route->ctrl;
        $ctrlFile = CTRL . $ctrlClass . '.php';
        if (!is_file($ctrlFile)) {
            throw new \Exception("Can't find Ctrl" . $ctrlClass);
        }
        $log_message = 'ctrl:' . $ctrlClass . '|ip:' . get_ip();
        lib\log::log($log_message, 'visit');
        include $ctrlFile;
        $className = '\\app\\ctrl\\' . $ctrlClass;
        $ctrl = new $className();
        echo json_encode($ctrl->main());

    }

    public static function load($class)
    {
        if (isset($classMap[$class]))
            return true;
        $class = str_replace('\\', '/', $class);
        $file = APIS . '/' . $class . '.php';
        if (is_file($file)) {
            include $file;
            self::$classMap[$class] = $class;
        } else {
            return false;
        }
        return true;
    }
}

abstract class ApiCtrl
{
    abstract public function main();
}
