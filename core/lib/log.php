<?php

namespace core\lib;
class log
{
    /**
     * 1.make sure log's storage
     * 2.write log
     */
    public static $class;

    public static function init()
    {
        $drive = conf::get("DRIVE", "log");
        $class = "\core\lib\drive\log\\" . $drive;
        self::$class = new $class;
    }

    public static function log($message, $file = "log")
    {
        self::$class->log($message, $file);
    }
}