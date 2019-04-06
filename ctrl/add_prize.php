<?php

namespace app\ctrl;

use core\lib\model\HistoryModel as his;

class add_prize extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
            $_2 = $_METHOD['name'];
            $_3 = $_METHOD['award'];
            $_4 = $_METHOD['number'];
            $_5 = $_SERVER['REQUEST_TIME'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //可选参数赋值
        $_6 = $_7 = null;
        if (isset($_METHOD['prob']) && $_METHOD['prob'] !== "") $_6 = $_METHOD['prob'];
        if (isset($_METHOD['img']) && $_METHOD['img'] !== "") $_7 = $_METHOD['img'];

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if ($uid < 0) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        //检查是否是uid创建的rid这个房间
        $res = model("History")->get_room_history($_1, his::MAKING, $_5);
        $res = $res->fetchAll();
        if (count($res) !== 1 || $res[0]['uid'] != $uid) {
            $response['result'] = "failure";
            return $response;
        }

        //检查图片文件是否正确
        if ($_7 !== null && !is_img_file($_7)) {
            $response['result'] = "invalid img";
            return $response;
        }

        //加入奖项
        model("Prize")->add_prize($_1, $_2, $_3, $_4, $_6, $_7);
        $response['result'] = "success";
        return $response;
    }
}