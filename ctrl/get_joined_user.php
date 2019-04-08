<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class get_joined_user extends \core\ApiCtrl
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

        //检查uid是否参加了rid
        $res = model("History")->check_user_in_room($uid, $_1);
        if (!$res) {
            $response['result'] = "not joined";
            return $response;
        }

        //取历史记录
        $res = model("History")->get_room_history($_1, his::JOIN);
        $res = $res->fetchAll();
        clear_fetchAll($res);

        //封装结果
        $response['result'] = "success";
        $response['user'] = $res;
        return $response;
    }
}