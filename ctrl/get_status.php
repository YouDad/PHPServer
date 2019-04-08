<?php

namespace ctrl;

class get_status extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_GET;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
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

        //取状态返回
        $response['result'] = model("History")->get_status($res);
        $res = model("History")->get_user_got($uid);
        $res = $res->fetchAll();
        clear_fetchAll($res);
        for ($i = 0, $j = count($res); $i < $j; $i++) {
            if ($res[$i]['rid'] != $_1) {
                unset($res[$i]);
            }
            if (strtotime('now') > 60 + strtotime($res[$i]['time'])) {
                unset($res[$i]);
            }
        }
        $response['prize'] = $res;
        return $response;
    }
}