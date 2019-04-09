<?php

namespace ctrl;

class get_info extends \core\ApiCtrl
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

        //取信息返回
        $res = model("User")->get_info($uid);
        $res = $res->fetchAll();
        clear_fetchAll($res);
        $response += $res[0];
        $response['result'] = "success";
        return $response;
    }
}