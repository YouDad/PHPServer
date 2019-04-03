<?php

namespace app\ctrl;

class login extends \core\ApiCtrl
{
    public function main()
    {
        $ret['result'] = 'failure';
        if (!isset($_GET['username']) ||
            !isset($_GET['password']) ||
            !isset($_GET['time']))
            return $ret;
        $res = model('User')->check_user($_GET['username'], $_GET['password'], $_GET['time']);
        if (!$res)
            return $ret;
        $ret['result'] = 'success';

        return $ret;
    }
}
