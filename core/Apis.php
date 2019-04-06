<?php

namespace core;

use core\lib as lib;

class Apis
{
    /* @var array $classMap 类的映射 */
    public static $classMap = [];

    /**
     * 框架的主函数,运行函数
     * @throws \Exception
     */
    public static function run()
    {
        global $IMG, $CTRL;
        //初始化日志
        lib\log::init();

        //用路由类解析url
        $route = new lib\route();

        //是否是访问图片的请求
        if ($route->is_img) {
            $url = "$IMG/$route->img_url";
            $img = file_get_contents($url, true);
            header("Content-Type: image/jpeg;text/html; charset=utf-8");
            echo $img;
            return;
        }

        $ctrlClass = $route->ctrl;
        $className = "\\ctrl\\$ctrlClass";
        $ctrlFile = "$CTRL/$ctrlClass.php";
        if (!is_file($ctrlFile)) {
            throw new \Exception("Can't find Ctrl:$ctrlClass");
        }
        lib\log::log("ctrl:$ctrlClass|ip:" . get_ip(), "ctrl");
        include $ctrlFile;

        /* @var ApiCtrl $ctrl 初始化调用的控制器类 */
        $ctrl = new $className();

        $response = $ctrl->main();
        if ($response !== null) {
            echo json_encode($response);
        }
    }

    /**
     * 类未加载时自动调用的函数
     * @param string $class
     * @return bool
     */
    public static function load($class)
    {
        global $APIS;
        //先检查缓存
        if (isset($classMap[$class])) {
            return true;
        }

        //把反斜杠转化成斜杠,找到类的文件
        $class = str_replace("\\", "/", $class);
        if (is_file("$APIS/$class.php")) {
            include "$APIS/$class.php";
            return self::$classMap[$class] = true;
        } else {
            return false;
        }
    }
}
