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

        $res = model("Room")->get_room($_0);
        $res = [$res];
        clear_fetchAll($res);
        $res = $res[0];

        if ($res['access'] > 2) {
            $response['result'] = "invalid room";
            return $response;
        }

        $response += $res;
        $res = model("Prize")->get_prize($response['rid'])->fetchAll();
        clear_fetchAll($res);
        $response['prize'] = $res;

        $response['result'] = "success";
        return $response;
    }
}