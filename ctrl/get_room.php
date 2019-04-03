<?php

namespace app\ctrl;

class get_room extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();

        return $model->get_room($_GET['rid']);
    }
}