<?php

namespace core\lib\model;

const T_LOG = 'log';

class LogModel extends \core\lib\MyDB
{
    private function check_log()
    {
        $res = $this->select(T_LOG)->fetchAll();
        $now = get_time() / 24 / 60 / 60;
        sscanf($res[0]['day'], "%d", $i);
        $last_content = $res[0]['content'];
        for ($j = 0, $k = null; $i <= $now; $i++) {
            if ($j < count($res))
                sscanf($res[$j]['day'], "%d", $k);
            if ($i == $k) {
                $last_content = $res[$j++]['content'];
            } else {
                $this->insert(T_LOG, "(day,content)", "('$i','$last_content')");
            }
        }
    }

    public function get_log_size()
    {
        $this->check_log();
        $v = $this->select(T_LOG, 'day')->fetchAll();
        return count($v);
    }

    /**
     * @param $i
     * @return mixed
     */
    public function get_log($i)
    {
        $this->check_log();
        $res = $this->select(T_LOG, 'content', "day='$i'");
        $v = $res->fetchAll();
        return $v[0]['content'];
    }

    /**
     * 更新一个日志
     * @param int $i 日志id
     * @param string $c 内容
     * @param string $p 密码
     * @return bool 是否通过密码验证
     */
    public function update_log($i, $c, $p)
    {
        $this->check_log();
        if ($p != md5("123456789"))
            return false;
        $this->update(T_LOG, "content", "'$c'", "day='$i'");
        return true;
    }
}