<?php

namespace ctrl;

class UnitTest extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='view/UnitTest/' />";
        $path = "$VIEW/UnitTest/index.html";
        include($path);
        return null;
    }
}
