<?php

namespace core\lib\model;

const T_PRIZE = 'hottery_prize';

class PrizeModel extends \core\lib\MyDB
{
    /**
     * 依照参数添加奖项
     * @param int $rid
     * @param string $name
     * @param string $award
     * @param int $number
     * @param null $prob
     * @param null $img
     * @return false|\PDOStatement
     */
    public function add_prize($rid, $name, $award, $number, $prob = null, $img = null)
    {
        $columns = sprintf("(rid,name,award,number%s%s)",
            reserve($prob, ",prob"),
            reserve($img, ",img"));
        $values = sprintf("(%d,'%s','%s',%d%s%s)", $rid, $name, $award, $number,
            reserve($prob, ",'$prob'"),
            reserve($img, ",'$img'"));
        return $this->insert(T_PRIZE, $columns, $values);
    }

    /**
     * 获得一个房间的奖项
     * @param int $rid
     * @return false|\PDOStatement
     */
    public function get_prize($rid)
    {
        return $this->select(T_PRIZE, "*", "rid=" . $rid);
    }

    public function check_prize($pid, $rid)
    {
        $res = $this->select(T_PRIZE, "*", "rid=$rid AND pid=$pid");
        $res = $res->fetchAll();
        return 1 === count($res);
    }

    public function del_prize($pid)
    {
        return $this->delete(T_PRIZE, "pid=" . $pid);
    }
}