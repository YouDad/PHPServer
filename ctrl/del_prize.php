<?php

namespace app\ctrl;

use core\lib\model\HistoryModel as his;

class del_prize extends \core\ApiCtrl
{
    public function main()
    {
        $_1 = $_POST['cookie'];
        $_2 = $_POST['rid'];
        $_3 = $_POST['pid'];
        $_4 = $_SERVER['REQUEST_TIME'];
        $response['result'] = "failure";


        //TODO 判断这个cookie是否合法
        //TODO 判断这个房间是否合法
        //TODO 判断这个cookie是否是这个房间的创建者
        //TODO 判断奖项号是否合法
        //TODO 判断时间是否合法
        //TODO 删除奖项
    }
}