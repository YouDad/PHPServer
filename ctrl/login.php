<?php

namespace app\ctrl;

class login extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        return $model->check_user($_GET['username'],
            $_GET['password'], $time = $_GET['time']);
    }
}
