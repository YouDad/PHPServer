<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class get_list extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
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
        $res_ing = model("History")->get_room_history($_1, his::MAKE);
        $res_ing = $res_ing->fetchAll();
        $res_ed = model("History")->get_room_history($_1, his::MAKE);
        $res_ed = $res_ed->fetchAll();
        $res = $res_ing + $res_ed;
        if (count($res) !== 1 || $res[0]['uid'] != $uid) {
            $response['result'] = "failure";
            return $response;
        }

        //把名单信息取出来,返回
        $res = model("Room")->get_list($_1);
        $res = $res->fetchAll();
        clear_fetchAll($res);
        $response['list'] = $res;
        $response['result'] = "success";
        return $response;
    }
}