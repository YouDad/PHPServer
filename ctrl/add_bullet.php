<?php

namespace ctrl;

class add_bullet extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
            $_2 = $_METHOD['content'];
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

        //检查uid是否参加了rid
        $res = model("History")->check_user_in_room($uid, $_1);
        if (!$res) {
            $response['result'] = "invalid rid";
            return $response;
        }

        //加弹幕返回
        model("Bullet")->add_bullet($_1, $uid, $_2);
        $response['result'] = "success";
        return $response;
    }
}