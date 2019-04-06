<?php

namespace core\lib\model;

const T_ROOM = 'hottery_room';

class RoomModel extends \core\lib\MyDB
{
    public function get_all_room()
    {
        $res = $this->select(T_ROOM, "*",
            "access BETWEEN 1 AND 2");
        return $res->fetchAll();
    }

    public function get_room($rid)
    {
        $res = $this->select(T_ROOM, "*",
            "rid=" . $rid);
        return $res->fetchAll()[0];
    }

    /**
     * @param string $t
     * @param string $s
     * @param string $a
     * @param string $i
     * @param string $o
     * @return int
     */
    public function add_room($t, $s, $a, $i, $o)
    {
        $this->insert(T_ROOM, '(title,start_time,access,img,other_option)',
            sprintf("('%s','%s','%s','%s','%s')", $t, $s, $a, $i, $o));
        $res = $this->select(T_ROOM, 'MAX(rid)')->fetchAll();
        return $res[0][0];
    }

}