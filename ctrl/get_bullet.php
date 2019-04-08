<?php

namespace ctrl;

class get_bullet extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
            $_2 = $_METHOD['start'];
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

        //取弹幕返回
        $res = model("Bullet")->get_bullet($_1, $_2);
        $res = $res->fetchAll();
        clear_fetchAll($res);

        //封装结果
        $response['result'] = "success";
        $response['bullet'] = $res;
        return $response;
    }
}