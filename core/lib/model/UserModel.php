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
        $res = $this->select(T_USER, "*", "username=" . $username);
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
        $where = "username=" . $username;
        $res = $this->select(T_USER, "*", $where);
        if (count($res->fetchAll()) != 0)
            return false;
        $columns = sprintf("(username,pass_md5%s%s)",
            reserve($level, ",level"), reserve($phone_number, ",phone_number"));
        $values = sprintf("(%s,%s%s%s)",
            $username, $password,
            reserve($level, ",'%s'", $level),
            reserve($phone_number, ",'%s'", $phone_number));
        $this->insert(T_USER, $columns, $values);
        $values = sprintf("('%s')", $username);
        $this->insert(T_UID, "(username)", $values);
        return true;
    }

    /**
     * @param $username :hottery_user.username
     * @return int
     */
    public function get_uid($username)
    {
        $where = "username=" . $username;
        $t = $this->select(T_UID, "uid", $where);
        return $t->fetchAll()[0][0];
    }

    /**
     * 为测试写的,删除固定用户1的函数
     */
    public function delete_user_for_test()
    {
        return $this->delete(T_USER, "username=1");
    }
}