<?php

namespace core\lib\model;

class BulletModel extends \core\lib\MyDB
{
    /**
     * 返回属于$rid的,bid大于$bid的所有弹幕
     * @param int $rid
     * @param int $bid
     * @return \PDOStatement
     */
    public function get_bullet($rid, $bid)
    {
        $table1 = T_BULLET . ' A';
        $table2 = T_UID . ' B';
        $columns = "B.username,A.time,A.content,A.bid";
        $where = "A.uid=B.uid AND A.rid='$rid' AND A.bid > '$bid'";
        $res = $this->select([$table1, $table2], $columns, $where);
        return $res;
    }

    /**
     * 添加一条由$uid在$rid内容为$content的弹幕
     * @param int $rid
     * @param int $uid
     * @param string $content
     * @return \PDOStatement
     */
    public function add_bullet($rid, $uid, $content)
    {
        $columns = "(uid,rid,content)";
        $values = "('$uid','$rid','$content')";
        return $this->insert(T_BULLET, $columns, $values);
    }

}