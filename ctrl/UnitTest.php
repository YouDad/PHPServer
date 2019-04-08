<?php

namespace ctrl;

class UnitTest extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='view/UintTest' />";
        $path = "$VIEW/UnitTest/index.html";
        include($path);
        return null;
    }
}
