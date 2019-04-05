<?php

namespace core\lib;

class conf
{
    public static $conf = array();

    public static function get($name, $file)
    {
        /**
         * 1.judge configure file's existing
         * 2.judge configure's existing
         * 3.cache configure
         */
        if (isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        }
        $path = CORE . "config/" . $file . ".php";
        if (!is_file($path)) {
            throw new \Exception("Can't find configure file:" . $path);
        }
        $conf = include $path;
        if (!isset($conf[$name])) {
            throw new \Exception("Can't find configure:" . $name);
        }
        self::$conf[$file] = $conf;
        return $conf[$name];
    }

    public static function all($file)
    {
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        }
        $path = CORE . "config/" . $file . ".php";
        if (!is_file($path)) {
            throw new \Exception("Can't find configure file:" . $path);
        }
        $conf = include $path;
        self::$conf[$file] = $conf;
        return $conf;
    }
}