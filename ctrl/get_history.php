<?php

namespace ctrl;

class get_history extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['type'];
            $_2 = $_SERVER['REQUEST_TIME'];
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

        //检查type是否正确
        if (4 < $_1 || $_1 < 0) {
            $response['result'] = "invalid type";
            return $response;
        }

        //取历史记录
        $res = model("History")->get_user_history($uid, $_1, $_2);
        clear_fetchAll($res);

        //封装结果
        $response['result'] = "success";
        $response['history'] = $res;
        return $response;
    }
}