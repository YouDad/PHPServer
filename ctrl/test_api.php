<?php

namespace ctrl;

class test_api extends \core\ApiCtrl
{
    public function main()
    {
        echo "<base href='view/test_api/' />";
        $path = APIS . "view/test_api/index.html";
        include($path);
        return null;
    }
}
