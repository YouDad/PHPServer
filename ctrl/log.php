<?php

namespace ctrl;

class log extends \core\ApiCtrl
{
    public function main()
    {
        global $APIS;
        include("$APIS/view/work_log/index.html");
        return null;
    }
}
