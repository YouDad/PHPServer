<?php

namespace app\ctrl;

class put_log extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        if (!isset($_POST['i']) ||
            !isset($_POST['c']) ||
            !isset($_POST['p'])) {
            $ret['result'] = 'failure';
            return $ret;
        } else {
            return $model->update_log($_POST['i'], $_POST['c'], $_POST['p']);
        }
    }
}
