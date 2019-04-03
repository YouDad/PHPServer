<?php

namespace app\ctrl;

class register extends \core\ApiCtrl
{
    public function main()
    {
        $_1 = $_GET['username'];
        $_2 = $_GET['password'];
        $response = ['result' => 'failure'];

        if (!isset($_1) || !isset($_2)) {
            return $response;
        }

        if (!model('User')->add_user($_1, $_2)) {
            return $response;
        }

        $response['result'] = 'success';

        $uid = model('User')->get_uid($_1);
        $response['cookie'] = model('Cookie')->gen_cookie($uid);

        return $response;
    }
}