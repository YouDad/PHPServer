<?php

namespace core\lib\model;

const T_HISTORY = 'hottery_history';
const T_ROOM = 'hottery_room';

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
        if ($time === null) {
            $columns = "(uid,rid,type)";
            $values = sprintf("(%d,%d,%d)", $uid, $rid, $type);
        } else {
            $columns = "(uid,rid,type,time)";
            $values = sprintf("(%d,%d,%d,%d)", $uid, $rid, $type, $time);
        }
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
        $type = $type / 2;
        $op = $type % 2 ? "<" : ">=";
        return $this->select(T_HISTORY, "*",
            "rid=$rid AND type=$type AND time$op$time");
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
        $_1 = $type / 2;
        $_2 = $type % 2 ? "<$time" : ">=$time";
        $where = "A.rid=B.rid AND uid=$uid AND type=$_1 AND B.start_time$_2";
        $res = $this->select([T_HISTORY . " A", T_ROOM . " B"], "A.rid,B.title", $where);

        return $res->fetchAll();
    }

}

































