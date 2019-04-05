<?php

namespace app\ctrl;

class login extends \core\ApiCtrl
{
    public function main()
    {
        $_1 = $_GET['username'];
        $_2 = $_GET['password'];
        $_3 = $_GET['time'];
        $response['result'] = "failure";

        if (!isset($_1) || !isset($_2) || !isset($_3)) {
            return $response;
        }

        $_4 = get_server_time();
        $_5 = $_SERVER['REQUEST_TIME'];
        if (abs($_4 - $_5) > 3) {
            return ['result' => 'timeout'];
        }

        if (!model("User")->check_user($_1, $_2, $_3)) {
            return $response;
        }

        $response['result'] = "success";

        $uid = model("User")->get_uid($_1);
        $response['cookie'] = model("Cookie")->gen_cookie($uid);

        return $response;
    }
}
