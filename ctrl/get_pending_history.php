<?php

namespace app\ctrl;

use core\lib\model\HistoryModel as his;

class get_pending_history extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_SERVER['REQUEST_TIME'];
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

        $res = model("History")->get_user_history($uid, his::JOINING, $_1);
        clear_fetchAll($res);

        $response['result'] = "success";
        $response['history'] = $res;
        return $response;
    }
}