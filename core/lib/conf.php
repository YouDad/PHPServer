<?php

namespace core\lib;

class conf
{
    /* @var array 保存配置的变量 */
    public static $conf = [];

    /**
     * 获得$file配置的$name属性
     * @param string $name 属性名
     * @param string $file 配置的文件名
     * @return mixed
     * @throws \Exception
     */
    public static function get($name, $file)
    {
        global $CONFIG;
        //缓存的配置直接返回
        if (isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        }

        //找到配置文件
        $path = "$CONFIG/$file.php";
        if (!is_file($path)) {
            throw new \Exception("Can't find configure file:$path");
        }

        //引入配置文件,判断属性是否在配置内
        $conf = include $path;
        if (!isset($conf[$name])) {
            throw new \Exception("Can't find configure:$name");
        }

        //缓存配置,返回指定属性
        self::$conf[$file] = $conf;
        return $conf[$name];
    }

    /**
     * 获得$file配置
     * @param string $file 配置的文件名
     * @return string
     * @throws \Exception
     */
    public static function all($file)
    {
        global $CONFIG;
        //缓存的配置直接返回
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        }

        //找到配置文件
        $path = "$CONFIG/$file.php";
        if (!is_file($path)) {
            throw new \Exception("Can't find configure file:$path");
        }

        //缓存配置,返回整个配置
        return self::$conf[$file] = include $path;
    }
}