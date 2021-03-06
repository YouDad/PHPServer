<?php

namespace core\lib\model;

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
        $res = $this->select(T_ROOM, "MAX(rid)");
        $res = $res->fetchAll();
        return $res[0][0];
    }

    /**
     * 编辑$rid的房间信息
     * @param int $rid
     * @param string $t
     * @param string $i
     * @param string $o
     */
    public function edit_room($rid, $t, $i, $o)
    {
        $where = "rid='$rid'";
        $this->update(T_ROOM, "title", "'$t'", $where);
        $this->update(T_ROOM, "img", "'$i'", $where);
        $this->update(T_ROOM, "other_option", "'$o'", $where);
    }

    /**
     * 给$rid房间加一个$list名单
     * @param int $rid
     * @param string $name
     * @param string $number
     * @param string $option
     */
    public function add_list($rid, $name, $number, $option)
    {
        $columns = "(rid,name,phone_number,option)";
        $values = "('$rid','$name','$number','$option')";
        $this->insert(T_LIST, $columns, $values);
    }

    /**
     * 获得$rid房间的名单
     * @param int $rid
     * @return \PDOStatement
     */
    public function get_list($rid)
    {
        $column = "name,phone_number,option";
        $where = "rid='$rid'";
        $res = $this->select(T_LIST, $column, $where);
        return $res;
    }

    /**
     * 获得房间权限等级
     * @param int $rid
     * @return int
     * @throws \Exception
     */
    public function get_level($rid)
    {
        $res = $this->select(T_ROOM, "*", "rid='$rid'");
        $res = $res->fetchAll();
        if (count($res) === 0) {
            throw new \Exception("not have access");
        }
        return $res[0]['access'];
    }

}