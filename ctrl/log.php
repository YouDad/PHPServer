<?php

namespace ctrl;

class log extends \core\ApiCtrl
{
    public function main()
    {
        include(APIS . "view/work_log/index.html");
        return null;
    }
}
