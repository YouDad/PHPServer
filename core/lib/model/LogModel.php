<?php

namespace core\lib\model;

const T_LOG = 'log';

class LogModel extends \core\lib\MyDB
{
    protected function select($column = '*', $where = '')
    {
        return parent::select(T_LOG, $column, $where);
    }

    protected function insert($columns, $values)
    {
        return parent::insert(T_LOG, $columns, $values);
    }

    protected function update($column, $content, $where = '')
    {
        return parent::update(T_LOG, $column, $content, $where);
    }

    private function check_log()
    {
        $res = $this->select()->fetchAll();
        $now = get_time() / 24 / 60 / 60;
        sscanf($res[0]['day'], "%d", $i);
        $last_content = $res[0]['content'];
        for ($j = 0; $i <= $now; $i++) {
            if ($j < count($res))
                sscanf($res[$j]['day'], "%d", $k);
            if ($i == $k) {
                $last_content = $res[$j]['content'];
                $j++;
                continue;
            } else {
                $this->insert("(day,content)",
                    sprintf("(%d,'%s')", $i, $last_content));
            }
        }
    }

    public function get_log_size()
    {
        $this->check_log();
        $v = $this->select('day')->fetchAll();
        return count($v);
    }

    public function get_log($i)
    {
        $this->check_log();
        $res = $this->select('content', "day=" . $i);
        $v = $res->fetchAll();
        return $v[0]['content'];
    }

    public function update_log($i, $c, $p)
    {
        $this->check_log();
        if ($p != md5("123456789"))
            return false;
        $this->update("content", sprintf("'%s'", $c), "day=" . $i);
        return true;
    }
}