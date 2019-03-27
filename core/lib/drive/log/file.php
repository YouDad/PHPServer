<?php

namespace core\lib\drive\log;

use core\lib\conf;

class file
{
    public $path;#log storage location

    public function __construct()
    {
        $this->path = conf::get('OPTION', 'log')['PATH'];
    }

    public function log($message, $file)
    {
        $path = $this->path . date('YmdH') . '/';
        if (!is_dir($path)) {
            mkdir($path, '0777', true);
        }
        $message = date('Y-m-d H:i:s') . $message;
        file_put_contents($path . $file . '.php',
            json_encode($message) . PHP_EOL,
            FILE_APPEND);
    }
}