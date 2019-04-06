<?php

namespace core\lib;

use PDO;

class MyDB
{
    protected $pdo;
    private $cnf;
    private $db;

    private function __construct()
    {
        $this->cnf = conf::all("database");
        $this->db = $this->cnf['DATABASE'];
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

    protected function query($_1, $_2 = null, $_3 = null, $_4 = null)
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


    protected function select($table, $column = "*", $where = null)
    {
        if (is_array($table)) {
            $tables = [];
            foreach ($table as $t) {
                array_push($tables, "$this->db.$t");
            }
            $table = join(",", $tables);
        } else {
            $table = "$this->db.$table";
        }
        $where = reserve($where, "WHERE $where");
        $sql = "SELECT $column FROM $table $where;";
        return $this->query($sql);
    }

    protected function update($table, $column, $content, $where = null)
    {
        $table = "$this->db.$table";
        $where = reserve($where, "WHERE $where");
        $sql = "UPDATE $table SET $column = $content $where;";
        return $this->query($sql);
    }

    protected function insert($table, $columns, $values)
    {
        $table = "$this->db.$table";
        $sql = "INSERT INTO $table$columns VALUES$values;";
        return $this->query($sql);
    }

    protected function delete($table, $where)
    {
        $table = "$this->db.$table";
        $sql = "DELETE FROM $table WHERE $where;";
        return $this->query($sql);
    }

}