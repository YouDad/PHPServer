<?php

namespace ctrl;

class index extends \core\ApiCtrl
{
    public function main()
    {
        global $APIS;
        echo "<base href='view/hottery/main/' />";
        $path = "$APIS/view/hottery/main/home.html";
        include($path);
        return null;
    }
}
