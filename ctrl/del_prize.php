<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class del_prize extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
            $_2 = $_METHOD['pid'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if (!$uid) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        //检查是否是uid创建的rid这个房间
        $res = model("History")->get_room_history($_1, his::MAKE);
        $res = $res->fetchAll();
        if (count($res) !== 1 || $res[0]['uid'] != $uid) {
            $response['result'] = "failure";
            return $response;
        }

        //检查奖项号
        if (!model("Prize")->check_prize($_2, $_1)) {
            $response['result'] = "invalid prize";
            return $response;
        }

        //删除奖项
        model("Prize")->del_prize($_2);
        $response['result'] = "success";
        return $response;
    }
}