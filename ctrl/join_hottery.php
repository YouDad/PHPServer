<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class join_hottery extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
        } catch (\Exception $exception) {
            //必选参数不能为空;
            return $response;
        }

        //可选参数赋值
        $_2 = null;
        if (isset($_METHOD['cdkey']) && $_METHOD['cdkey'] !== "") $_2 = $_METHOD['cdkey'];

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if (!$uid) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        $res = model("History")->check_user_in_room($uid, $_1);
        if ($res !== false) {
            $response['result'] = "already";
            return $response;
        }

        if (model("Room")->get_level($_1) == 2) {
            //检查cdkey是否正确
            $rid = model("Cdkey")->cdkey_to_rid($_2);
            if (!$rid || $rid != $_1) {
                $response['result'] = "invalid cdkey";
                return $response;
            }
        }

        //记录他的加入
        model("History")->add_history($uid, $_1, his::JOIN);
        $response['result'] = "success";
        return $response;
    }
}