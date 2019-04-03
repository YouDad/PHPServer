<?php

namespace core\lib\model;

const T_ROOM = 'hottery_room';

class RoomModel extends \core\lib\MyDB
{
    public function get_all_room()
    {
        $ret = array('result' => 'success');
        $res = $this->select(T_ROOM, '*', 'access=1 OR access=2');
        $ret['option'] = $res->fetchAll();
        return $ret;
    }

    public function get_room($rid)
    {
        $ret = array('result' => 'success');
        $res = $this->select(T_ROOM, '*', '(access=1 OR access=2) AND rid=' . $rid);
        $ret['option'] = $res->fetchAll()[0];
        return $ret;
    }

    public function add_room($t, $s, $a, $i, $o)
    {
        $this->insert(T_ROOM, '(title,start_time,access,img,other_option)',
            sprintf('(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\')', $t, $s, $a, $i, $o));
        return array('result' => 'success');
    }


}