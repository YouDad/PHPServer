<?php

namespace core\lib\model;

const T_COOKIE = 'hottery_cookie';

class CookieModel extends \core\lib\MyDB
{
    /**
     * 清理过期cookie 或 把uid的cookie清空
     * @param $uid => hottery_cookie.uid
     * @return void
     */
    private function clear_cookie($uid = -1)
    {
        $this->delete(T_COOKIE,
            sprintf('valid_time<%d OR uid=%d', get_time(), $uid));
    }

    /**
     * 根据cookie返回uid
     * @param $cookie => hottery_cookie.cookie
     * @return int    => hottery_cookie.uid
     *  1. <0 =>没有这个cookie
     *  2. >0 =>正常结果
     */
    public function get_user($cookie)
    {
        $this->clear_cookie();
        $res = $this->select(T_COOKIE, 'uid',
            'cookie=\'' . $cookie . "'")->fetchAll();
        if (count($res) == 0) {
            return -1;
        } else {
            return $res[0]['uid'];
        }
    }

    /**
     * 给uid生成一个cookie,有效期为3天
     * @param $uid => hottery_cookie.uid
     * @return string => hottery_cookie.cookie
     */
    public function gen_cookie($uid)
    {
        $this->clear_cookie($uid);
        $cookie = md5(rand()) . md5(rand()) . md5(rand()) . md5(rand());
        $this->insert(T_COOKIE, '(uid,cookie,valid_time)',
            sprintf('(\'%s\',\'%s\',%d)',
                $uid, $cookie, get_time() + 24 * 60 * 60 * 3));
        return $cookie;
    }

}