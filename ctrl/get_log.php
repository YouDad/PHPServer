<?php

namespace app\ctrl;

class get_log extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        if (!isset($_GET['i'])) {
            return $model->get_log_size();
        } else {
            return $model->get_log($_GET['i']);
        }
    }
}
