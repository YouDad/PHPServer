<?php

namespace core\lib\model;

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
     * @return \PDOStatement
     */
    public function add_prize($rid, $name, $award, $number, $prob = null, $img = null)
    {
        $column1 = reserve($prob, ",prob");
        $column2 = reserve($img, ",img");
        $columns = "(rid,name,award,number$column1,$column2)";
        $value1 = reserve($prob, ",'$prob'");
        $value2 = reserve($img, ",'$img'");
        $values = "('$rid','$name','$award','$number'$value1$value2)";
        return $this->insert(T_PRIZE, $columns, $values);
    }

    /**
     * 获得一个房间的奖项
     * @param int $rid
     * @return \PDOStatement
     */
    public function get_prize($rid)
    {
        return $this->select(T_PRIZE, "*", "rid='$rid'");
    }

    /**
     * 检查$pid这个奖项是不是$rid的奖项
     * @param int $pid
     * @param int $rid
     * @return bool
     */
    public function check_prize($pid, $rid)
    {
        $where = "rid=$rid AND pid=$pid";
        $res = $this->select(T_PRIZE, "*", $where);
        $res = $res->fetchAll();
        return 1 === count($res);
    }

    /**
     * 删除$pid这个奖项
     * @param int $pid
     * @return \PDOStatement
     */
    public function del_prize($pid)
    {
        return $this->delete(T_PRIZE, "pid='$pid'");
    }

}