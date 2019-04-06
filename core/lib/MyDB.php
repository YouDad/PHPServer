<?php

namespace core\lib;

use PDO;

class MyDB
{
    protected $pdo;
    private $cnf;

    private function __construct()
    {
        $this->cnf = conf::all("database");
        $this->pdo = new \PDO($this->cnf['DSN'], $this->cnf['USERNAME'], $this->cnf['PASSWORD']);
        //make sure table is exist
        foreach ($this->cnf['TABLE_DEFINE'] as $v) {
            $this->pdo->exec(sprintf("%s %s.%s",
                $this->cnf['CREATE_TABLE'], $this->cnf['DATABASE'], $v));
        }
    }

    protected static $ins = [];

    /**
     * @return static
     */
    public static function getIns()
    {
        $className = get_called_class();
        if (!isset(static::$ins[$className]))
            static::$ins[$className] = new $className();
        return static::$ins[$className];
    }

    private function query($_1, $_2 = null, $_3 = null, $_4 = null)
    {
        if ($_4 !== null)
            $ret = $this->pdo->query($_1, $_2, $_3, $_4);
        else if ($_3 !== null)
            $ret = $this->pdo->query($_1, $_2, $_3);
        else if ($_2 !== null)
            $ret = $this->pdo->query($_1, $_2);
        else
            $ret = $this->pdo->query($_1);
        if (!$ret) {
            dump($_1);
            exit;
        }
        return $ret;
    }


    protected function select($table, $column = "*", $where = "")
    {
        if ($where != "") {
            $sql = sprintf("SELECT %s FROM %s.%s WHERE %s;",
                $column, $this->cnf['DATABASE'], $table, $where);
        } else {
            $sql = sprintf("SELECT %s FROM %s.%s;",
                $column, $this->cnf['DATABASE'], $table);
        }
        return $this->query($sql);
    }

    protected function update($table, $column, $content, $where = "")
    {
        if ($where != "") {
            $sql = sprintf("UPDATE %s.%s SET %s = %s WHERE %s;",
                $this->cnf['DATABASE'], $table, $column, $content, $where);
        } else {
            $sql = sprintf("UPDATE %s.%s SET %s = %s;",
                $this->cnf['DATABASE'], $table, $column, $content);
        }
        return $this->query($sql);
    }

    protected function insert($table, $columns, $values)
    {
        $sql = sprintf("INSERT INTO %s.%s%s VALUES%s;",
            $this->cnf['DATABASE'], $table, $columns, $values);
        return $this->query($sql);
    }

    protected function delete($table, $where)
    {
        $sql = sprintf("DELETE FROM %s.%s WHERE %s;",
            $this->cnf['DATABASE'], $table, $where);
        return $this->query($sql);
    }

}