<?php

namespace app\ctrl;

class test_img extends \core\ApiCtrl
{
    public function main()
    {
        echo "<base href='view/test_img/' />";
        $path = APIS . "view/test_img/index.html";
        include($path);
        return null;
    }
}
