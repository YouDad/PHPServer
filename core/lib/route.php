<?php

namespace core\lib;
class route
{
    public $ctrl;
    public $action;

    public function __construct()
    {
        // xxx.com/(index.php/)index/index
        /**
         * 1.hide index.php
         * 2.get URL parameters
         * 3.return corresponding ctrl and method
         */
        if (!isset($_SERVER['REQUEST_URI']) ||
            $_SERVER['REQUEST_URI'] == '/') {
            $this->ctrl = conf::get('CTRL', 'route');
            $this->action = conf::get('ACTION', 'route');
        }
        $path = $_SERVER['REQUEST_URI'];
        $pathArr = explode('/', trim($path, '/'));
        if (isset($pathArr[0])) {
            $this->ctrl = $pathArr[0];
        }
        if (isset($pathArr[1])) {
            $this->action = $pathArr[1];
        } else {
            $this->action = conf::get('ACTION', 'route');
        }
        $cnt = count($pathArr);
        $i = 2;
        while ($i + 1 < $cnt) {
            $_GET[$pathArr[$i]] = $pathArr[$i + 1];
            $i = $i + 2;
        }
    }
}

