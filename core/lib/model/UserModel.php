<?php

namespace core\lib\model;

const T_USER = 'hottery_user';
const T_UID = 'hottery_uid';

class UserModel extends \core\lib\MyDB
{
    /**
     * @param string $username
     * @param string $password
     * @param int $time
     * @return boolean
     *  1.true 登录成功
     *  2.false 登录失败
     */
    public function check_user($username, $password, $time)
    {
        $where = "username='$username'";
        $res = $this->select(T_USER, "*", $where);
        $v = $res->fetchAll();
        if (count($v) == 0)
            return false;
        $md5 = md5($v[0]['pass_md5'] . $time);
        return $md5 == $password;
    }

    /**
     * @param string $username
     * @param string $password
     * @param null $level
     * @param null $phone_number
     * @return boolean
     *  1.true 注册成功
     *  2.false 注册失败
     */
    public function add_user($username, $password, $level = null, $phone_number = null)
    {
        //默认权限等级是1
        if ($level === null) {
            $level = 1;
        }

        $where = "username='$username'";
        $res = $this->select(T_USER, "*", $where);
        if (count($res->fetchAll()) != 0)
            return false;
        $columns = sprintf("(username,pass_md5%s%s)",
            reserve($level, ",level"), reserve($phone_number, ",phone_number"));
        $values = sprintf("('%s','%s'%s%s)",
            $username, $password,
            reserve($level, ",$level"),
            reserve($phone_number, ",'$phone_number'"));
        $this->insert(T_USER, $columns, $values);
        $this->insert(T_UID, "(username)", "('$username')");
        return true;
    }

    /**
     * @param $username :hottery_user.username
     * @return int
     */
    public function get_uid($username)
    {
        $where = "username='$username'";
        $t = $this->select(T_UID, "uid", $where);
        return $t->fetchAll()[0]['uid'];
    }

    /**
     * 为测试写的,删除固定用户1的函数
     */
    public function delete_user_for_test()
    {
        return $this->delete(T_USER, "username='1'");
    }

    /**
     * @param $uid int
     * @return int
     *  1.>0 正确的等级
     *  2.<0 这个用户没有等级
     */
    public function get_level($uid)
    {
        $where = "uid=" . $uid;
        $res = $this->select(T_UID, "username", $where);
        $res = $res->fetchAll();
        if (count($res) === 0) {
            return -1;
        }
        $username = $res[0]['username'];
        $where = "username='$username'";
        $res = $this->select(T_USER, "level", $where);
        $res = $res->fetchAll();
        if (count($res) === 0) {
            return -1;
        }
        return $res[0]['level'];
    }

}