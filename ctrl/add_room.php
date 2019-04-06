<?php

namespace ctrl;

use core\lib\model\HistoryModel as his;

class add_room extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['cookie'];
            $_1 = $_METHOD['title'];
            $_2 = $_METHOD['start_time'];
            $_3 = $_METHOD['access'];
            $_4 = $_METHOD['img'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //可选参数赋值
        $_5 = null;
        if (isset($_METHOD['other_option'])) $_5 = $_METHOD['other_option'];

        //检查cookie是否正确
        $uid = model("Cookie")->get_user($_0);
        if ($uid < 0) {
            $response['result'] = "invalid cookie";
            return $response;
        }

        //检查标题的长度
        if (isset($_1[32])) {
            $response['result'] = "invalid title";
            return $response;
        }

        //检查附加信息的长度
        if ($_5 !== null && isset($_5[1024])) {
            $response['result'] = "invalid other_option";
            return $response;
        }

        //检查开始时间
        if (get_server_time() > $_2) {
            $response['result'] = "invalid start_time";
            return $response;
        }

        //检查权限
        $level = model('User')->get_level($uid);
        switch ($_3) {
            case 1:
            case 2:
                if ($level < 2) {
                    $response['result'] = "invalid access";
                    return $response;
                }
                break;
            case 3:
                if ($level < 3) {
                    $response['result'] = "invalid access";
                    return $response;
                }
                break;
        }

        //检查图片文件是否正确
        if (!is_img_file($_4)) {
            $response['result'] = "invalid img";
            return $response;
        }

        //加个房间
        $rid = model("Room")->add_room($_1, $_2, $_3, $_4, $_5);
        model("History")->add_history($uid, $rid, his::MAKE);
        $response['result'] = "success";
        $response['rid'] = $rid;
        return $response;
    }
}