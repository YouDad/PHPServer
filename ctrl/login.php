<?php

namespace ctrl;

class login extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['username'];
            $_1 = $_METHOD['password'];
            $_2 = $_METHOD['time'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

////        dump(get_server_time(), $_SERVER['REQUEST_TIME']);
//
//        //时间不能相差太大
//        if (abs(get_server_time() - $_SERVER['REQUEST_TIME']) > 3) {
//            $response['result'] = "timeout";
//            return $response;
//        }

        //确定账号密码是否正确
        $res = model("User")->check_user($_0, $_1, $_2);
        if (!$res) {
            return $response;
        }

        //生成一个cookie返回
        $response['result'] = "success";
        $uid = model("User")->get_uid($_0);
        $response['cookie'] = model("Cookie")->gen_cookie($uid);
        return $response;
    }
}
