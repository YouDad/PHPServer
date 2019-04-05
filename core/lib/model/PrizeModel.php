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
            reserve($prob, ",'%s'", $prob),
            reserve($img, ",'%s'", $img));
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
}