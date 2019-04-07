<?php

namespace ctrl;

class get_room extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['rid'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //取房间信息
        $res = model("Room")->get_room($_0);
        clear_fetchAll($res);
        $res = $res[0];

        //检查权限
        if ($res['access'] > 2) {
            $response['result'] = "invalid room";
            return $response;
        }

        //把奖项信息取出来,返回
        $response += $res;
        $res = model("Prize")->get_prize($response['rid'])->fetchAll();
        clear_fetchAll($res);
        $response['prize'] = $res;

        $response['result'] = "success";
        return $response;
    }
}