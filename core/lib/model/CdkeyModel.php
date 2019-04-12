<?php

namespace core\lib\model;

class CdkeyModel extends \core\lib\MyDB
{
    /**
     * 根据cdkey返回对应的房间号,如果无效则返回false
     * @param string $cdkey
     * @return false|int
     */
    public function cdkey_to_rid($cdkey)
    {
        $res = $this->select(T_CDKEY, "rid", "cdkey='$cdkey'");
        $res = $res->fetchAll();
        if ($res) {
            return $res[0]['rid'];
        } else {
            return false;
        }
    }

    /**
     * 添加一个cdkey
     * @param int $rid
     * @param string $cdkey
     * @return \PDOStatement
     */
    public function add_cdkey($rid, $cdkey)
    {
        return $this->insert(T_CDKEY, "(rid,cdkey)", "('$rid','$cdkey')");
    }
}