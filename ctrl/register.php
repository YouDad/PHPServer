<?php

namespace app\ctrl;

class register extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        if (!isset($_GET['username']) ||
            !isset($_GET['password']))
            return array('result' => 'failure');
        return $model->add_user($_GET['username'], $_GET['password']);
    }
}