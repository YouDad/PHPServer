<?php

namespace core\lib;

class mydb extends \PDO
{
    public $conf;

    public function __construct()
    {
        $this->conf = conf::all('database');
        $dsn = $this->conf['DSN'];
        $username = $this->conf['USERNAME'];
        $password = $this->conf['PASSWORD'];
        parent::__construct($dsn, $username, $password);
        //make sure database is exist
        $sql = $this->conf['CREATE_DATABASE'];
        $this->exec($sql);
        //make sure table is exist
        foreach ($this->conf['TABLE_DEFINE'] as $v) {
            $this->check_table($v);
        }
    }

    private function check_table($table_define)
    {
        $sql = $this->conf['CREATE_TABLE'] . $this->conf['DATABASE'] . '.' . $table_define;
        $this->exec($sql);
    }

    protected function select($table, $column = '*', $where = '')
    {
        if ($where != '') {
            $sql = sprintf('SELECT %s FROM %s.%s WHERE %s;',
                $column, $this->conf['DATABASE'], $table, $where);
        } else {
            $sql = sprintf('SELECT %s FROM %s.%s;',
                $column, $this->conf['DATABASE'], $table);
        }
        return $this->query($sql);
    }

    protected function update($table, $column, $content, $where = '')
    {
        if ($where != '') {
            $sql = sprintf('UPDATE %s.%s SET %s = %s WHERE %s;',
                $this->conf['DATABASE'], $table, $column, $content, $where);
        } else {
            $sql = sprintf('UPDATE %s.%s SET %s = %s;',
                $this->conf['DATABASE'], $table, $column, $content);
        }
        return $this->query($sql);
    }

    protected function insert($table, $columns, $values)
    {
        $sql = sprintf('INSERT INTO %s.%s%s VALUES%s;',
            $this->conf['DATABASE'], $table, $columns, $values);
        return $this->query($sql);
    }

    protected function delete($table, $where)
    {
        $sql = sprintf('DELETE FROM %s.%s WHERE %s;',
            $this->conf['DATABASE'], $table, $where);
        return $this->query($sql);
    }

}
