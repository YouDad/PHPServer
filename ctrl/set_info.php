<?php

namespace ctrl;

class set_info extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //可选参数赋值
        $_1 = $_2 = null;
        if (isset($_METHOD['phone_number']) && $_METHOD['phone_number'] !== "") {
            $_1 = $_METHOD['phone_number'];
        }
        if (isset($_METHOD['email']) && $_METHOD['email'] !== "") {
            $_2 = $_METHOD['email'];
        }

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if (!$uid) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        //修改个人信息
        model("User")->set_info($uid, $_1, $_2);
        $response['result'] = "success";
        return $response;
    }
}