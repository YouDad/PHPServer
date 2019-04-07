<?php

namespace core\lib\model;

const T_LOG = 'log';

class LogModel extends \core\lib\MyDB
{
    /**
     * 首先是补全日志之间的空隙
     * 其次是对未有而应有的日志进行默认处理
     */
    private function check_log()
    {
        $res = $this->select(T_LOG);
        $res = $res->fetchAll();
        $now = get_time() / 24 / 60 / 60;
        sscanf($res[0]['day'], "%d", $i);
        $last_content = $res[0]['content'];
        for ($j = 0, $k = null; $i <= $now; $i++) {
            if ($j < count($res))
                sscanf($res[$j]['day'], "%d", $k);
            if ($i == $k) {
                $last_content = $res[$j++]['content'];
            } else {
                $values = "('$i','$last_content')";
                $this->insert(T_LOG, "(day,content)", $values);
            }
        }
    }

    /**
     * 获得日志大小
     * @return int
     */
    public function get_size()
    {
        $this->check_log();
        $res = $this->select(T_LOG, 'day');
        $res = $res->fetchAll();
        return count($res);
    }

    /**
     * 获得第$i天的日志
     * @param $i
     * @return string|false
     */
    public function get_log($i)
    {
        $this->check_log();
        $res = $this->select(T_LOG, 'content', "day='$i'");
        $res = $res->fetchAll();
        if (count($res) !== 0) {
            return $res[0]['content'];
        } else {
            return false;
        }
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
        if ($p != md5("123456789")) {
            return false;
        }
        $content = "'$c'";
        $where = "day='$i'";
        $this->update(T_LOG, "content", $content, $where);
        return true;
    }

}