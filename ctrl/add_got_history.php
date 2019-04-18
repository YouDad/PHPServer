<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class add_got_history extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['rid'];
            $_2 = $_METHOD['uid_pid_json_array'];
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

//        //检查是否是uid创建的rid这个房间
//        $res = model("History")->get_room_history($_1, his::MAKE);
//        $res = $res->fetchAll();
//        if (count($res) !== 1 || $res[0]['uid'] != $uid) {
//            $response['result'] = "failure";
//            return $response;
//        }

        //增加历史
        $res = true;
        $response['result'] = "invalid uid_pid_json_array";
        try {
            $uid_pid = json_decode($_2);
            foreach ($uid_pid as $up) {
                $u = $up->uid;
                $p = $up->pid;
                $res = model('History')->add_got($u, $_1, $p);
            }
        } catch (\Exception $exception) {
            //格式错误
            return $response;
        }
        if (!$res) {
            $response['result'] = "not in room uid get pid";
            return $response;
        }


        $response['result'] = "success";
        return $response;
    }
}