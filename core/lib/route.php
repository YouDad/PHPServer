<?php

namespace core\lib;
class route
{
    public $ctrl;

    public function __construct()
    {
        // xxx.com/(index.php/)index/index
        /**
         * 1.hide index.php
         * 2.requests URL parameters
         * 3.return corresponding ctrl and method
         */
        \core\lib\log::log(serialize($_SERVER), 'requests');
        if (!isset($_SERVER['REQUEST_URI']) ||
            $_SERVER['REQUEST_URI'] == '/') {
            $this->ctrl = conf::get('CTRL', 'route');
            return;
        }
        $path = $_SERVER['REQUEST_URI'];
        $pathArr = explode("/", trim($path, '/'));
        if (count($pathArr) == 1) {
            $pathArr = explode('?', $pathArr[0]);
        }
        if (isset($pathArr[0]) and $this->is_exist_ctrl($pathArr[0])) {
            $this->ctrl = $pathArr[0];
        } else {
            $this->ctrl = conf::get('CTRL', 'route');
        }

        # /id/1/str/asd => ['id']=1 , ['str']=asd
        $cnt = count($pathArr);
        $i = 1;
        while ($i + 1 < $cnt) {
            $_GET[$pathArr[$i]] = $pathArr[$i + 1];
            $i = $i + 2;
        }
        if ($i > $cnt) {
            $_GET['other'] = $pathArr[$i];
        }
    }

    private function is_exist_ctrl($ctrl_name)
    {
        return is_file(CTRL . $ctrl_name . '.php');
    }
}

