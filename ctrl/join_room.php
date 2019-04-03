<?php

namespace app\ctrl;

class join_room extends \core\ApiCtrl
{
    public function main()
    {
        $ret['result'] = 'success';
        $ret['title'] = '昭哥牛逼';
        $ret['rid'] = 29;
        return $ret;
    }
}
