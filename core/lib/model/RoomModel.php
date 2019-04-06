<?php

namespace core\lib\model;

const T_ROOM = 'hottery_room';

class RoomModel extends \core\lib\MyDB
{
    /**
     * 直接返回所有 权限在[1,2] 的房间
     * @return array
     */
    public function get_all_room()
    {
        $res = $this->select(T_ROOM, "*", "access BETWEEN 1 AND 2");
        return $res->fetchAll();
    }

    /**
     * 根据房间号来返回一个房间的信息
     * @param int $rid
     * @return mixed
     */
    public function get_room($rid)
    {
        $res = $this->select(T_ROOM, "*", "rid='$rid'");
        return $res->fetchAll()[0];
    }

    /**
     * 根据五个变量来添加一个房间
     * @param string $t 房间标题
     * @param string $s 房间开始抽奖时间
     * @param string $a 房间权限
     * @param string $i 房间照片名
     * @param string $o 房间其他选项
     * @return int
     */
    public function add_room($t, $s, $a, $i, $o)
    {
        $this->insert(T_ROOM,
            '(title,start_time,access,img,other_option)',
            "('$t','$s','$a','$i','$o')");
        $res = $this->select(T_ROOM, 'MAX(rid)')->fetchAll();
        return $res[0][0];
    }

}