<?php

namespace ctrl;

class temp_room extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cdkey'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        $rid = model("Cdkey")->cdkey_to_rid($_0);
        if (!$rid) {
            return $response;
        }
        setcookie('rid', $rid, time() + 3600 * 24 * 365 * 100, "/");
        global $VIEW;
        echo "<base href='view/WebLottery/source/' />";
        $path = "$VIEW/WebLottery/source/tmp_room.html";
        include($path);
        return null;
    }
}