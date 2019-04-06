<?php

namespace ctrl;

class put_log extends \core\ApiCtrl
{
    public function main()
    {
        $response = ['result' => 'failure'];
        $_1 = $_POST['i'];
        $_2 = $_POST['c'];
        $_3 = $_POST['p'];
        if (isset($_1) && isset($_2) && isset($_3)) {
            if (model("Log")->update_log($_1, $_2, $_3)) {
                $response['result'] = "success";
                $response['content'] = model("Log")->get_log($_1);
            }
        }
        return $response;
    }
}
