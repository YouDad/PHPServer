<?php

namespace core\lib\model;

class UserModel extends \core\lib\MyDB
{
    /**
     * 检查用户的密码是否正确,返回登录是否成功
     * @param string $username
     * @param string $password
     * @param int $time
     * @return bool
     */
    public function check_user($username, $password, $time)
    {
        $where = "username='$username'";
        $res = $this->select(T_USER, "*", $where);
        $res = $res->fetchAll();
        if (count($res) == 0) {
            return false;
        }
        $md5 = md5($res[0]['pass_md5'] . $time);
        return $md5 === $password;
    }

    /**
     * 检查用户是否已经注册,如果没有,则注册,返回是否注册成功
     * @param string $username
     * @param string $password
     * @param null $level
     * @param null $phone_number
     * @return bool
     */
    public function add_user($username, $password, $level = null, $phone_number = null)
    {
        //默认权限等级是1
        if ($level === null) {
            $level = 1;
        }

        //检查是否存在同名用户
        $where = "username='$username'";
        $res = $this->select(T_USER, "*", $where);
        if (count($res->fetchAll()) !== 0) {
            //存在同名用户
            return false;
        }

        //注册该用户
        $column1 = reserve($level, ",level");
        $column2 = reserve($phone_number, ",phone_number");
        $columns = "(username,pass_md5$column1$column2)";
        $value1 = reserve($level, ",'$level'");
        $value2 = reserve($phone_number, ",'$phone_number'");
        $values = "('$username','$password'$value1$value2)";
        $this->insert(T_USER, $columns, $values);

        //插入uid的表
        $this->insert(T_UID, "(username)", "('$username')");
        return true;
    }

    /**
     * 返回$username的uid
     * @param string $username
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
     * 根据$uid得到他的等级
     * @param $uid int
     * @return int|false
     */
    public function get_level($uid)
    {
        $table1 = T_UID . ' A';
        $table2 = T_USER . ' B';
        $where = "A.username=B.username AND A.uid='$uid'";
        $res = $this->select([$table1, $table2], "B.level", $where);
        $res = $res->fetchAll();
        if (count($res) === 0) {
            return false;
        }
        return $res[0]['level'];
    }

}