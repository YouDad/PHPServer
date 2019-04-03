<?php

namespace app\ctrl;

class join_hottery extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        if (!isset($_GET['cookie']) ||
            !isset($_GET['rid']) ||
            !isset($_GET['cdkey'])) {
            return array('result' => 'failure');
        } else {
            if (-1 === $model->get_user_by_cookie($_GET['cookie'])) {
                return array('result' => 'invalid cookie');
            }
            switch ($model->check_cdkey($_GET['rid'], $_GET['cdkey'])) {
                case 0:
                    return array('result' => 'invalid cdkey');
                case 1:
                    return array('result' => 'success');
                case 2:
                    return array('result' => 'already');
                default:
                    return array('result' => 'failure');
            }
        }
    }
}
