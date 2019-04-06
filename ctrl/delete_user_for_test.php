<?php

namespace ctrl;

class delete_user_for_test extends \core\ApiCtrl
{
    public function main()
    {
        $response['result'] = "success";
        model("User")->delete_user_for_test();
        return $response;
    }
}
