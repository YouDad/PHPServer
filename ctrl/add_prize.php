<?php

namespace app\ctrl;

use core\lib\model\HistoryModel as his;

class add_prize extends \core\ApiCtrl
{
    public function main()
    {
        $_1 = $_POST['cookie'];
        $_2 = $_POST['rid'];
        $_3 = $_SERVER['REQUEST_TIME'];
        $response['result'] = "failure";

        $uid = model("Cookie")->get_user($_1);
        $res = model("History")->get_history($_2, his::MAKING, $_3);

        //TODO 判断这个cookie是否是这个房间的创建者
        //TODO 判断时间是否合法
        //TODO 加入奖项
    }
}