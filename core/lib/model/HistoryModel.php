<?php

namespace core\lib\model;

const T_HISTORY = 'hottery_history';
const T_ROOM = 'hottery_room';
const T_GOT = 'hottery_got';
const T_PRIZE = 'hottery_prize';

class HistoryModel extends \core\lib\MyDB
{
    const MAKE = 0, JOIN = 1;
    const MAKING = 0, MADE = 1, JOINING = 2, JOINED = 3;

    /**
     * 添加一条历史
     * @param int $uid
     * @param int $rid
     * @param 0|1 $type
     *  type只有HistoryModel的JOIN和MAKE
     * @param null $time
     *  time默认是当前时间
     * @return false|\PDOStatement
     */
    public function add_history($uid, $rid, $type, $time = null)
    {
        $column = reserve($time, ",time");
        $value = reserve($time, ",'$time'");
        $columns = "(uid,rid,type$column)";
        $values = "('$uid','$rid','$type'$value)";
        return $this->insert(T_HISTORY, $columns, $values);
    }

    /**
     * 获得一个房间的历史信息
     * @param int $rid
     * @param 0|1|2|3 $type
     *  type只有HistoryModel的MAKING,MADE,JOINING,JOINED
     * @param int $time
     * @return false|\PDOStatement
     * @throws \Exception
     */
    public function get_room_history($rid, $type, $time)
    {
        if (4 < $type || $type < 0) {
            throw new \Exception("type error!");
        }
        $_1 = $type / 2;
        $_2 = $type % 2 ? "<" : ">=";
        $where = "rid=$rid AND type=$_1 AND time$_2$time";
        return $this->select(T_HISTORY, "*", $where);
    }

    /**
     * 获得一个用户的历史信息
     * @param int $uid
     * @param 0|1|2|3 $type
     *  type只有HistoryModel的MAKING,MADE,JOINING,JOINED
     * @param int $time
     * @return array
     * @throws \Exception
     */
    public function get_user_history($uid, $type, $time)
    {
        if (4 < $type || $type < 0) {
            throw new \Exception("type error!");
        }
        $table1 = T_HISTORY . " A";
        $table2 = T_ROOM . " B";
        $_1 = $type / 2;
        $_2 = $type % 2 ? "<$time" : ">=$time";
        $where = "A.rid=B.rid AND uid=$uid AND type=$_1 AND B.start_time$_2";
        $res = $this->select([$table1, $table2], "A.rid,B.title", $where);

        return $res->fetchAll();
    }

    /**
     * 判断$uid是不是在$rid这个房间里
     * @param int $uid
     * @param int $rid
     * @return bool
     */
    public function check_user_in_room($uid, $rid)
    {
        $where = "uid='$uid' AND rid='$rid'";
        $res = $this->select(T_HISTORY, "*", $where);
        $res = $res->fetchAll();
        return count($res) === 1;
    }

    /**
     * 获得$uid的所有获奖信息
     * @param int $uid
     * @return \PDOStatement
     */
    public function get_user_got($uid)
    {
        $t1 = T_GOT . ' A';
        $t2 = T_HISTORY . ' B';
        $t3 = T_ROOM . ' C';
        $t4 = T_PRIZE . ' D';
        $column = "A.time,B.rid,C.title,D.name,D.award,D.img";
        $where = "A.hid=B.hid AND B.rid=C.rid AND A.pid=D.pid AND B.uid=$uid";
        $res = $this->select([$t1, $t2, $t3, $t4], $column, $where);
        return $res;
    }

    /**
     * 获得$rid的所有获奖信息
     * @param int $rid
     * @return \PDOStatement
     */
    public function get_room_got($rid)
    {
        $table1 = T_GOT . ' A';
        $table2 = T_HISTORY . ' B';
        $column = "A.pid,B.uid,B.time";
        $where = "A.hid=B.hid AND B.rid=$rid";
        $res = $this->select([$table1, $table2], $column, $where);
        return $res;
    }

}

































