<?php

namespace ctrl;

class index extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='view/hottery/main/' />";
        $path = "$VIEW/hottery/main/home.html";
        include($path);
        return null;
    }
}
