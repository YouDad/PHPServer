<?php

namespace ctrl;

class test_img extends \core\ApiCtrl
{
    public function main()
    {
        global $APIS;
        echo "<base href='view/test_img/' />";
        $path = "$APIS/view/test_img/index.html";
        include($path);
        return null;
    }
}
