<?php

namespace core\lib\model;

const T_ROOM = 'hottery_room';

class RoomModel extends \core\lib\MyDB
{
    /**
     * 直接返回所有 权限在[1,2] 的房间
     * @return \PDOStatement
     */
    public function get_all_room()
    {
        $where = "access BETWEEN 1 AND 2";
        $res = $this->select(T_ROOM, "*", $where);
        return $res;
    }

    /**
     * 根据房间号来返回一个房间的信息
     * @param int $rid
     * @return array
     */
    public function get_room($rid)
    {
        $res = $this->select(T_ROOM, "*", "rid='$rid'");
        $res = $res->fetchAll();
        return $res;
    }

    /**
     * 根据五个变量来添加一个房间,返回新房间的rid
     * @param string $t 房间标题
     * @param string $s 房间开始抽奖时间
     * @param string $a 房间权限
     * @param string $i 房间照片名
     * @param string $o 房间其他选项
     * @return int 新房间的rid
     */
    public function add_room($t, $s, $a, $i, $o)
    {
        //插入房间的记录
        $columns = "(title,start_time,access,img,other_option)";
        $values = "('$t','$s','$a','$i','$o')";
        $this->insert(T_ROOM, $columns, $values);

        //返回这个新房间的rid
        $res = $this->select(T_ROOM, 'MAX(rid)');
        $res = $res->fetchAll();
        return $res[0][0];
    }

}