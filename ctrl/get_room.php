<?php

namespace app\ctrl;

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
        for ($i = 0; $i < 6; $i++) {
            unset($res[$i]);
        }
        $response += $res;
        $res = model("Prize")->get_prize($response['rid'])->fetchAll();
        clear_fetchAll($res);
        $response['prize'] = $res;

        $response['result'] = "success";
        return $response;
    }
}