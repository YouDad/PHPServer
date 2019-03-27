<?php

namespace core\lib;

class model extends \PDO
{
    public function __construct()
    {
        $conf = conf::all('database');
        $dsn = $conf['DSN'];
        $username = $conf['USERNAME'];
        $passwd = $conf['PASSWD'];
        try {
            parent::__construct($dsn, $username, $passwd);
        } catch (\PDOException $e) {
            p($e->getMessage());
        }
    }
}
