<?php

namespace core\lib;
class route
{
    /* @var string $ctrl 解析出来的控制器 */
    public $ctrl;

    /* @var bool $is_img 判断是不是在访问图片 */
    public $is_img = false;

    /* @var string $img_url 如果是在访问图片,就记录图片的url */
    public $img_url;

    /**
     * 初始化一个路由类
     * @throws \Exception
     */
    public function __construct()
    {
        //记录所有请求的三个变量
        if (isset($_SERVER)) log::log(serialize($_SERVER), "\$_SERVER");
        if (isset($_GET)) log::log(serialize($_GET), "\$_GET");
        if (isset($_POST)) log::log(serialize($_POST), "\$_POST");

        //请求的url
        $url = $_SERVER['REQUEST_URI'];

        //访问根目录
        if (!isset($url) || $url === "/") {
            $this->ctrl = conf::get("CTRL", "route");
            return;
        }

        //用斜杠分隔
        $arr = explode("/", trim($url, "/"));

        //判断是不是图片
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

    }

    /**
     * 判断这个控制器是否存在
     * @param string $ctrl_name
     * @return bool
     */
    private function is_exist_ctrl($ctrl_name)
    {
        global $CTRL;
        return is_file("$CTRL/$ctrl_name.php");
    }

    /**
     * 判断这张图片是否存在
     * @param string $img_name
     * @return bool
     */
    private function is_exist_img($img_name)
    {
        global $IMG;
        return is_file("$IMG/$img_name");
    }
}

