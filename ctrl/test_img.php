<?php

namespace ctrl;

class test_img extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='view/test_img/' />";
        $path = "$VIEW/test_img/index.html";
        include($path);
        return null;
    }
}
