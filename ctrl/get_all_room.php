<?php

namespace ctrl;

class get_all_room extends \core\ApiCtrl
{
    public function main()
    {
        $response['result'] = "success";
        $res = model("Room")->get_all_room();
        $res = $res->fetchAll();
        clear_fetchAll($res);
        $response['option'] = $res;

        return $response;
    }
}