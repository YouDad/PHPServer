<?php

namespace app\ctrl;

class requests extends \core\ApiCtrl
{
    public function main()
    {
        if(isset($_SERVER))dump($_SERVER);
        if(isset($_GET))dump($_GET);
        if(isset($_POST))dump($_POST);
        if(isset($_SESSION))dump($_SESSION);
    }
}
