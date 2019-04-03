<?php

namespace app\ctrl;

class index extends \core\ApiCtrl
{
    public function main()
    {
        echo '<base href="view/hottery/main/" />';
        $path = APIS . 'view/hottery/main/home.html';
        include($path);
        return '';
    }
}
