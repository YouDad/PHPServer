<?php

namespace ctrl;

class get_user_got extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
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

        //把获奖信息取出来,返回
        $res = model("History")->get_user_got($uid);
        $res = $res->fetchAll();
        clear_fetchAll($res);
        $response['got'] = $res;
        $response['result'] = "success";
        return $response;
    }
}