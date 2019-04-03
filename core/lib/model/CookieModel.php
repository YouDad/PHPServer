<?php

namespace core\lib\model;

const T_COOKIE = 'hottery_cookie';

class CookieModel extends \core\lib\MyDB
{

    private function clear_cookie()
    {
        $this->delete(T_COOKIE, 'valid_time<' . $this->get_time());
    }

    public function get_user_by_cookie($cookie)
    {
        $this->clear_cookie();
        $res = $this->select(T_COOKIE,'uid', 'cookie=\'' . $cookie . "'")->fetchAll();
        if (count($res) == 0) {
            return -1;
        } else {
            return $res[0]['uid'];
        }
    }

//    public function get_cookie($username,$)
    public function gen_cookie($uid)
    {
        $cookie = md5(rand()) . md5(rand()) . md5(rand()) . md5(rand());
        $this->insert(T_COOKIE, '(uid,cookie,valid_time)',
            sprintf('(\'%s\',\'%s\',%d)', $uid, $cookie, $this->get_time() + 24 * 60 * 60 * 3));
        return $cookie;
    }
}