<?php

namespace core\lib;

class MyDB
{
    protected $pdo;
    private $cnf;

    private function __construct()
    {
        $this->cnf = conf::all('database');
        $this->pdo = new \PDO($this->cnf['DSN'], $this->cnf['USERNAME'], $this->cnf['PASSWORD']);
        //make sure table is exist
        foreach ($this->cnf['TABLE_DEFINE'] as $v) {
            $this->pdo->exec(sprintf("%s %s.%s",
                $this->cnf['CREATE_TABLE'], $this->cnf['DATABASE'], $v));
        }
    }


    protected static $ins;

    /**
     * @return static
     */
    public static function getIns()
    {
        if (!isset(static::$ins))
            static::$ins = new static;
        return static::$ins;
    }

    protected function select($table, $column = '*', $where = '')
    {
        if ($where != '') {
            $sql = sprintf('SELECT %s FROM %s.%s WHERE %s;',
                $column, $this->cnf['DATABASE'], $table, $where);
        } else {
            $sql = sprintf('SELECT %s FROM %s.%s;',
                $column, $this->cnf['DATABASE'], $table);
        }
        return $this->pdo->query($sql);
    }

    protected function update($table, $column, $content, $where = '')
    {
        if ($where != '') {
            $sql = sprintf('UPDATE %s.%s SET %s = %s WHERE %s;',
                $this->cnf['DATABASE'], $table, $column, $content, $where);
        } else {
            $sql = sprintf('UPDATE %s.%s SET %s = %s;',
                $this->cnf['DATABASE'], $table, $column, $content);
        }
        return $this->pdo->query($sql);
    }

    protected function insert($table, $columns, $values)
    {
        $sql = sprintf('INSERT INTO %s.%s%s VALUES%s;',
            $this->cnf['DATABASE'], $table, $columns, $values);
        return $this->pdo->query($sql);
    }

    protected function delete($table, $where)
    {
        $sql = sprintf('DELETE FROM %s.%s WHERE %s;',
            $this->cnf['DATABASE'], $table, $where);
        return $this->pdo->query($sql);
    }


    /**
     * @return int
     * 返回秒级的时间
     */
    protected function get_time()
    {
        date_default_timezone_set("Asia/Shanghai");
        $zero1 = strtotime(date("y-m-d h:i:s"));
        $zero2 = strtotime("2000-01-01 00:00:00");
        return ($zero1 - $zero2);
    }
}
//
//class mydb extends \PDO
//{
//    public $cnf;
//
//    public function __construct()
//    {
//
//        $this->cnf = cnf::all('database');
//        $dsn = $this->cnf['DSN'];
//        $username = $this->cnf['USERNAME'];
//        $password = $this->cnf['PASSWORD'];
//        parent::__construct($dsn, $username, $password);
//        //make sure table is exist
//        foreach ($this->cnf['TABLE_DEFINE'] as $v) {
//            $this->check_table($v);
//        }
//    }
//
//    private function check_table($table_define)
//    {
//        $sql = $this->cnf['CREATE_TABLE'] . $this->cnf['DATABASE'] . '.' . $table_define;
//        $this->exec($sql);
//    }
//
//    protected function select($table, $column = '*', $where = '')
//    {
//        if ($where != '') {
//            $sql = sprintf('SELECT %s FROM %s.%s WHERE %s;',
//                $column, $this->cnf['DATABASE'], $table, $where);
//        } else {
//            $sql = sprintf('SELECT %s FROM %s.%s;',
//                $column, $this->cnf['DATABASE'], $table);
//        }
//        return $this->query($sql);
//    }
//
//    protected function update($table, $column, $content, $where = '')
//    {
//        if ($where != '') {
//            $sql = sprintf('UPDATE %s.%s SET %s = %s WHERE %s;',
//                $this->cnf['DATABASE'], $table, $column, $content, $where);
//        } else {
//            $sql = sprintf('UPDATE %s.%s SET %s = %s;',
//                $this->cnf['DATABASE'], $table, $column, $content);
//        }
//        return $this->query($sql);
//    }
//
//    protected function insert($table, $columns, $values)
//    {
//        $sql = sprintf('INSERT INTO %s.%s%s VALUES%s;',
//            $this->cnf['DATABASE'], $table, $columns, $values);
//        return $this->query($sql);
//    }
//
//    protected function delete($table, $where)
//    {
//        $sql = sprintf('DELETE FROM %s.%s WHERE %s;',
//            $this->cnf['DATABASE'], $table, $where);
//        return $this->query($sql);
//    }
//
//}
