<?php

namespace ctrl;

class log extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='../view/work_log/' />";
        include("$VIEW/work_log/index.html");
        return null;
    }
}
