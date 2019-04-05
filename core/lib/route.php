<?php

namespace core\lib;
class route
{
    public $ctrl;
    public $is_img = false;
    public $img_url;

    public function __construct()
    {
        // xxx.com/(index.php/)index/index
        /**
         * 1.hide index.php
         * 2.requests URL parameters
         * 3.return corresponding ctrl and method
         */
        if (isset($_SERVER)) \core\lib\log::log(serialize($_SERVER), "$_SERVER");
        if (isset($_GET)) \core\lib\log::log(serialize($_GET), "$_GET");
        if (isset($_POST)) \core\lib\log::log(serialize($_POST), "$_POST");

        $url = $_SERVER['REQUEST_URI'];

        if (!isset($url) || $url === "/") {
            $this->ctrl = conf::get("CTRL", "route");
            return;
        }

        $arr = explode("/", trim($url, "/"));

        if (count($arr) === 1 && strlen($arr[0]) === 32) {
            if (!$this->is_exist_ctrl($arr[0])) {
                if ($this->is_exist_img($arr[0])) {
                    $this->is_img = true;
                    $this->img_url = $arr[0];
                    return;
                }
            }
        }

        if (count($arr) == 1) {
            $arr = explode("?", $arr[0]);
        }
        if (isset($arr[0]) and $this->is_exist_ctrl($arr[0])) {
            $this->ctrl = $arr[0];
        } else {
            $this->ctrl = conf::get("CTRL", "route");
        }

        # /id/1/str/asd => ['id']=1 , ['str']=asd
        $cnt = count($arr);
        $i = 1;
        while ($i + 1 < $cnt) {
            $_GET[$arr[$i]] = $arr[$i + 1];
            $i = $i + 2;
        }
        if ($i > $cnt) {
            $_GET['other'] = $arr[$i];
        }
    }

    private function is_exist_ctrl($ctrl_name)
    {
        return is_file(CTRL . $ctrl_name . ".php");
    }

    private function is_exist_img($img_name)
    {
        return is_file(APIS . "img/" . $img_name);
    }
}

