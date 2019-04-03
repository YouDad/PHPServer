<?php

namespace app\ctrl;

class get_room extends \core\ApiCtrl
{
    public function main()
    {
        $_1 = $_GET['rid'];
        $response = ['result' => 'failure'];
        if (!isset($_1)) {
            return $response;
        }

        $response['result'] = 'success';
        $response['option'] = model('Room')->get_room($_1);

        return $response;
    }
}