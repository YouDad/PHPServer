<?php

namespace app\ctrl;

class add_room extends \core\ApiCtrl
{
    public function main()
    {
        $model = new \core\lib\model();
        /*title CHAR(32) NOT NULL,
          start_time TIMESTAMP  NOT NULL,
          access TINYINT NOT NULL,
          img CHAR(32),
          option VARCHAR(1024)*/
        if (!isset($_GET['title']) ||
            !isset($_GET['start_time']) ||
            !isset($_GET['access']) ||
            !isset($_GET['img']) ||
            !isset($_GET['other_option']))
            return ['result' => 'failure'];
        return $model->add_room(
            $_GET['title'],
            $_GET['start_time'],
            $_GET['access'],
            $_GET['img'],
            $_GET['other_option']
        );
    }
}