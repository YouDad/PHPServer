<?php

namespace app\ctrl;

class login extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        if (!isset($_GET['username']) ||
            !isset($_GET['password']) ||
            !isset($_GET['time']))
            return array('result' => 'failure');
        return $model->check_user($_GET['username'],
            $_GET['password'], $time = $_GET['time']);
    }
}
