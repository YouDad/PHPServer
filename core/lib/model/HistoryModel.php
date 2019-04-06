<?php

namespace core\lib\model;

const T_HISTORY = 'hottery_history';

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
     * @param 0|1 $type
     *  type只有HistoryModel的MAKING,MADE,JOINING,JOINED
     * @param int $time
     * @return false|\PDOStatement
     * @throws \Exception
     */
    public function get_history($rid, $type, $time)
    {
        switch ($type) {
            case self::MAKING:
                return $this->select(T_HISTORY, "*",
                    sprintf("rid=%d AND type=%d AND time>%d",
                        $rid, self::MAKE, $time));
            case self::MADE:
                return $this->select(T_HISTORY, "*",
                    sprintf("rid=%d AND type=%d AND time<%d",
                        $rid, self::MAKE, $time));
            case self::JOINING:
                return $this->select(T_HISTORY, "*",
                    sprintf("rid=%d AND type=%d AND time>%d",
                        $rid, self::JOIN, $time));
            case self::JOINED:
                return $this->select(T_HISTORY, "*",
                    sprintf("rid=%d AND type=%d AND time<%d",
                        $rid, self::JOIN, $time));
            default:
                throw new \Exception("type error!");
        }
    }
}