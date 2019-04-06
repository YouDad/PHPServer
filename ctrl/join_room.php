<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class join_room extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['cdkey'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if ($uid < 0) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        //检查cdkey是否正确
        $rid = model("Cdkey")->cdkey_to_rid($_1);
        if (!$rid) {
            $response['result'] = "invalid cdkey";
            return $response;
        }

        //返回房间信息
        $res = model("Room")->get_room($rid);
        $res = [$res];
        clear_fetchAll($res);
        $res = $res[0];
        $response += $res;
        $res = model("Prize")->get_prize($response['rid'])->fetchAll();
        clear_fetchAll($res);
        $response['prize'] = $res;

        //添加历史信息
        model("History")->add_history($uid, $rid, his::JOIN);

        $response['result'] = "success";
        return $response;
    }
}