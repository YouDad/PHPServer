<?php

namespace app\ctrl;

class get_all_room extends \core\ApiCtrl
{
    public function main()
    {
        $response['result'] = "success";
        $response['option'] = model("Room")->get_all_room();

        return $response;
    }
}