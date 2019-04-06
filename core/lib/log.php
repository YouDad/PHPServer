<?php

namespace core\lib;
class log
{
    /* @var \core\lib\drive\log\file $class 真正起作用的日志类 */
    public static $class;

    /**
     * 日志类的初始化函数
     * @throws \Exception
     */
    public static function init()
    {
        $drive = conf::get("DRIVE", "log");
        self::$class = new ("\core\lib\drive\log\\$drive");
    }

    public static function log($message, $file = "log")
    {
        self::$class->log($message, $file);
    }
}