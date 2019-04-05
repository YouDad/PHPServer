<?php

namespace core\lib\model;

const T_HISTORY = 'hottery_history';

class HistoryModel extends \core\lib\MyDB
{
    const MAKE = 0, JOIN = 1;
    const MAKING = 0, MADE = 1, JOINING = 2, JOINED = 3;

    public function add_history($uid, $rid, $type, $time)
    {
        $columns = "(uid,rid,type,time)";
        $values = sprintf("(%d,%d,%d,%d)", $uid, $rid, $type, $time);
        return $this->insert(T_HISTORY, $columns, $values);
    }

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