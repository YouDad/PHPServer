<?php

namespace core\lib;

class model extends \PDO
{
    public $conf;

    public function __construct()
    {
        $this->conf = conf::all('database');
        $dsn = $this->conf['DSN'];
        $username = $this->conf['USERNAME'];
        $password = $this->conf['PASSWORD'];
        parent::__construct($dsn, $username, $password);
    }

    private function check_table($name)
    {
        $sql = $this->conf['CREATE_DATABASE'];
        $this->exec($sql);
        $sql = $this->conf['CREATE_TABLE'] . $this->conf['DATABASE'] . '.' . $this->conf['TABLE_DEFINE'][$name];
        $this->exec($sql);
    }

    public function check_user($username, $password, $time)
    {
        $sql = 'SELECT * FROM ' . $this->conf['DATABASE'] . '.hottery_user WHERE username=\'' . $username . '\';';
        $v = $this->query($sql)->fetchAll();
        if (count($v) == 0) return 'false';
        $md5 = md5($v[0]['pass_md5'] . $time);
        \core\lib\log::log($md5 . '--' . $password, 'login');
        \core\lib\log::log('time='.$time,'login');
        return $md5 == $password ? "true" : "false";
    }
}
