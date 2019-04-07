<?php

namespace ctrl;

class register extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['username'];
            $_1 = $_METHOD['password'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //判断注册是否成功
        $res = model("User")->add_user($_0, $_1);
        if (!$res) {
            return $response;
        }

        //生成cookie返回
        $response['result'] = "success";
        $uid = model("User")->get_uid($_1);
        $response['cookie'] = model("Cookie")->gen_cookie($uid);
        return $response;
    }
}