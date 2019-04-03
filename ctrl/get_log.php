<?php

namespace app\ctrl;

class get_log extends \core\ApiCtrl
{
    public function main()
    {
        if (!isset($_GET['i'])) {
            return model('Log')->get_log_size();
        } else {
            return model('Log')->get_log($_GET['i']);
        }
    }
}
