<?php

namespace core\lib\model;
const T_BULLET = 'hottery_bullet';
const T_UID = 'hottery_uid';
const T_CDKEY = 'hottery_cdkey';
const T_COOKIE = 'hottery_cookie';
const T_HISTORY = 'hottery_history';
const T_ROOM = 'hottery_room';
const T_GOT = 'hottery_got';
const T_PRIZE = 'hottery_prize';
const T_LOG = 'log';
const T_USER = 'hottery_user';
const T_LIST = 'hottery_list';

namespace core\lib;

use PDO;

class MyDB
{
    /* @var PDO 唯一的php数据库对象 */
    protected $pdo;

    /* @var array php数据库的配置数组 */
    private $cnf;

    /* @var string 所用的php数据库的名字 */
    private $db;

    /**
     * 单例模式的私有构造函数
     * 读取配置,设置连接数据库的账号,确保接下来需要操作的表存在
     * @throws \Exception
     */
    private function __construct()
    {
        $this->cnf = conf::all("database");
        $this->db = $this->cnf['DATABASE'];
        $this->pdo = new PDO($this->cnf['DSN'], $this->cnf['USERNAME'], $this->cnf['PASSWORD']);
        //make sure table is exist
        foreach ($this->cnf['TABLE_DEFINE'] as $v) {
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS $this->db.$v");
        }
    }

    /* @var array 存放子类实例的数组 */
    protected static $ins = [];

    /**
     * 单例模式的获得实例函数
     * @return static
     */
    public static function getIns()
    {
        $className = get_called_class();
        if (!isset(static::$ins[$className])) {
            static::$ins[$className] = new $className();
        }
        return static::$ins[$className];
    }

    /**
     * 重写pdo的query方法以便截获sql错误
     * @param string $_1
     * @param null $_2
     * @param null $_3
     * @param null $_4
     * @return \PDOStatement
     */
    protected function query($_1, $_2 = null, $_3 = null, $_4 = null)
    {
        if ($_4 !== null) {
            $ret = $this->pdo->query($_1, $_2, $_3, $_4);
        } else if ($_3 !== null) {
            $ret = $this->pdo->query($_1, $_2, $_3);
        } else if ($_2 !== null) {
            $ret = $this->pdo->query($_1, $_2);
        } else {
            $ret = $this->pdo->query($_1);
        }
        if (!$ret) {
            dump($_1);
            exit;
        } else {
            log::log($ret->queryString, "sql");
        }
        return $ret;
    }

    /**
     * 重写的select,负责把参数变成sql语句然后查询
     * @param array|string $table 需要查询记录的表(名或名的数组)
     * @param string $column 需要查询记录的列
     * @param null $where 查询记录的条件
     * @return \PDOStatement
     */
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

    /**
     * 重写的update,负责把参数变成sql语句然后更新
     * @param string $table 需要更新记录的表
     * @param string $column 需要更新记录的列
     * @param string $content 需要更新记录的值
     * @param null $where 更新的条件
     * @return \PDOStatement
     */
    protected function update($table, $column, $content, $where = null)
    {
        $table = "$this->db.$table";
        $where = reserve($where, "WHERE $where");
        $sql = "UPDATE $table SET $column = $content $where;";
        return $this->query($sql);
    }

    /**
     * 重写的insert,负责把参数变成sql语句然后插入
     * @param string $table 需要插入记录的表
     * @param string $columns 需要插入记录的列
     * @param string $values 需要插入记录的值
     * @return \PDOStatement
     */
    protected function insert($table, $columns, $values)
    {
        $table = "$this->db.$table";
        $sql = "INSERT INTO $table$columns VALUES$values;";
        return $this->query($sql);
    }

    /**
     * 重写的delete,负责把参数变成sql语句然后删除
     * @param string $table 需要删除记录的表
     * @param string $where 删除记录的条件
     * @return \PDOStatement
     */
    protected function delete($table, $where)
    {
        $table = "$this->db.$table";
        $sql = "DELETE FROM $table WHERE $where;";
        return $this->query($sql);
    }

}