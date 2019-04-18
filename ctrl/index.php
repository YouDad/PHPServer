<?php

namespace ctrl;

class index extends \core\ApiCtrl
{
    public function main()
    {
        global $VIEW;
        echo "<base href='view/WebLottery/source/' />";
        $path = "$VIEW/WebLottery/source/index.html";
        include($path);
        return null;
    }
}
