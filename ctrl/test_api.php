<?php

namespace ctrl;

class test_api extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='view/test_api/' />";
        $path = "$VIEW/test_api/index.html";
        include($path);
        return null;
    }
}
