<?php

namespace ctrl;

class get_log extends \core\ApiCtrl
{
    public function main()
    {
        if (!isset($_GET['i'])) {
            $cnt = model("Log")->get_log_size();
            return ['result' => 'success', 'size' => $cnt];
        } else {
            $cnt = model("Log")->get_log_size();
            if ($cnt === 0) {
                return ['result' => 'failure'];
            } else {
                return ['result' => 'success',
                    'content' => model("Log")->get_log($_GET['i'])];
            }
        }
    }
}
