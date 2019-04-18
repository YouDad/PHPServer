<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class temp_info extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_COOKIE['rid'];
            $_1 = $_METHOD['nickname'];
            $_2 = $_METHOD['sid'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        if (!model("User")->add_stu($_1, $_2)) {
            $response['result'] = "invalid nickname";
            return $response;
        }

        //生成信息
        $uid = model("User")->get_uid($_1);
        $cookie = model("Cookie")->gen_cookie($uid);
        setcookie('cookie', $cookie, time() + 3600 * 24 * 365 * 100, "/");

        //返回房间信息
        $res = model("Room")->get_room($_0);
        clear_fetchAll($res);
        $res = $res[0];
        $response += $res;

        //添加历史信息
        model("History")->add_history($uid, $_0, his::JOIN);

        $response['result'] = "success";
        return $response;
    }
}