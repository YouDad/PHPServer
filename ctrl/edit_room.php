<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class edit_room extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['title'];
            $_2 = $_METHOD['img'];
            $_3 = $_METHOD['rid'];
            $_4 = $_SERVER['REQUEST_TIME'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //可选参数赋值
        $_5 = null;
        if (isset($_METHOD['other_option']) && $_METHOD['other_option'] !== "") $_5 = $_METHOD['other_option'];

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if (!$uid) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        //检查是否是uid创建的rid这个房间
        $res = model("History")->get_room_history($_3, his::MAKING, $_4);
        $res = $res->fetchAll();
        if (count($res) !== 1 || $res[0]['uid'] != $uid) {
            $response['result'] = "invalid rid";
            return $response;
        }

        //检查标题的长度
        if (isset($_1[32])) {
            $response['result'] = "invalid title";
            return $response;
        }

        //检查附加信息的长度
        if ($_5 !== null && isset($_5[1024])) {
            $response['result'] = "invalid other_option";
            return $response;
        }

        //检查图片文件是否存在
        if (!img_exists($_2)) {
            $response['result'] = "invalid img";
            return $response;
        }

        //修改房间
        $rid = model("Room")->edit_room($_3, $_1, $_2, $_5);
        $response['result'] = "success";
        return $response;
    }
}