<?php

namespace core\lib\drive\log;

use core\lib\conf;

class file
{
    /* @var string $path 保存日志存储位置 */
    public $path;

    /**
     * 用配置类配置路径
     * @throws \Exception
     */
    public function __construct()
    {
        $this->path = conf::get("OPTION", "log")['PATH'];
    }

    /**
     * 输出日志到文件里
     * @param string $message 消息
     * @param string $file 目标文件
     */
    public function log($message, $file)
    {
        //按照时间分文件夹存储日志
        $time = date("YmdH");
        $path = "$this->path/$time";

        //若文件夹不存在则创建一个
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        //输出日志,8是FILE_APPEND
        $time = date("Y-m-d H:i:s");
        $message = "$time> $message\n";
        file_put_contents("$path/$file.php_log", $message, 8);
    }

}