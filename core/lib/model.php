<?php

namespace core\lib;

const T_USER = 'hottery_user';
const T_ROOM = 'hottery_room';
const T_COOKIE = 'hottery_cookie';
const T_UID = 'hottery_uid';
const T_LOG = 'log';

class model extends mydb
{
    public function check_cdkey($rid, $cdkey)
    {
        if ($cdkey == "12345678")
            return 1;
        return 0;
    }

    public function get_user_by_cookie($cookie)
    {
        $this->clear_cookie();
        $res = $this->select(T_COOKIE, 'uid', 'cookie=\'' . $cookie . "'")->fetchAll();
        if (count($res) == 0) {
            return -1;
        } else {
            return $res[0]['uid'];
        }
    }

    public function check_user($username, $password, $time)
    {
        $ret = array('result' => 'failure');
        $res = $this->select(T_USER, '*', 'username=' . $username);
        $v = $res->fetchAll();
        if (count($v) == 0) return $ret;
        $md5 = md5($v[0]['pass_md5'] . $time);
        log::log('username=' . $username);
        log::log($md5 . ' ,but ' . $password, 'login');
        log::log('time=' . $time, 'login');
        if ($md5 == $password) {
            $ret['result'] = 'success';
            $cookie = $this->gen_cookie($this->get_uid($username));
            $ret['cookie'] = $cookie;
        }
        return $ret;
    }

    public function add_user($username, $password, $level = null, $phone_number = null)
    {
        $res = $this->select(T_USER, '*', 'username=' . $username);
        if (count($res->fetchAll()) != 0)
            return array('result' => 'failure');
        $columns = sprintf('(username,pass_md5%s%s)',
            $level === null ? "" : ",level",
            $phone_number === null ? "" : ",phone_number");
        $values = sprintf('(\'%s\',\'%s\'%s%s)',
            $username, $password,
            $level === null ? "" : "," . $level,
            $phone_number === null ? "" : ",'" . $phone_number . "'");
        $this->insert(T_USER, $columns, $values);
        $this->insert(T_UID, '(username)',
            sprintf('(\'%s\')', $username));
        $cookie = $this->gen_cookie($this->get_uid($username));
        $ret['cookie'] = $cookie;
        $ret['result'] = 'success';
        return $ret;
    }


    private function get_uid($username)
    {
        return $this->select(T_UID, 'uid', 'username=' . $username)->fetchAll()[0][0];
    }


    public function get_all_room()
    {
        $ret = array('result' => 'success');
        $res = $this->select(T_ROOM, '*', 'access=1 OR access=2');
        $ret['option'] = $res->fetchAll();
        return $ret;
    }

    public function get_room($rid)
    {
        $ret = array('result' => 'success');
        $res = $this->select(T_ROOM, '*', '(access=1 OR access=2) AND rid=' . $rid);
        $ret['option'] = $res->fetchAll()[0];
        return $ret;
    }

    public function add_room($t, $s, $a, $i, $o)
    {
        $this->insert(T_ROOM, '(title,start_time,access,img,other_option)',
            sprintf('(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\')', $t, $s, $a, $i, $o));
        return array('result' => 'success');
    }

//    public function get_cookie($username,$)
    public function gen_cookie($uid)
    {
        $cookie = md5(rand()) . md5(rand()) . md5(rand()) . md5(rand());
        $this->insert(T_COOKIE, '(uid,cookie,valid_time)',
            sprintf('(\'%s\',\'%s\',%d)', $uid, $cookie, $this->get_time() + 24 * 60 * 60 * 3));
        return $cookie;
    }

    private function clear_cookie()
    {
        $this->delete(T_COOKIE, 'valid_time<' . $this->get_time());
    }

//    public function confirm_cookie($cookie)
//    {
//        $this->clear_cookie();
//        $res = $this->select(T_COOKIE, 'uid', 'cookie=' . $cookie)->fetchAll();
//        if (count($res) == 0) {
//            return "";
//        } else {
//            return $res[0]['cookie'];
//        }
//    }

    private function get_time()
    {
        date_default_timezone_set("Asia/Shanghai");
        $zero1 = strtotime(date("y-m-d h:i:s"));
        $zero2 = strtotime("2000-01-01 00:00:00");
        return ($zero1 - $zero2);
    }

    private function check_log()
    {
        //TODO 检查log是否饱满
        $res = $this->select(T_LOG)->fetchAll();
        $now = $this->get_time() / 24 / 60 / 60;
        sscanf($res[0]['day'], '%d', $i);
        $last_content = $res[0]['content'];
        for ($j = 0; $i <= $now; $i++) {
            if ($j < count($res))
                sscanf($res[$j]['day'], '%d', $k);
            if ($i == $k) {
                $last_content = $res[$j]['content'];
                $j++;
                continue;
            } else {
                $this->insert(T_LOG, '(day,content)',
                    sprintf('(%d,\'%s\')', $i, $last_content));
            }
        }
    }

    public function get_log_size()
    {
        $this->check_log();
        $v = $this->select(T_LOG, 'day')->fetchAll();
        $ret['result'] = "success";
        $ret['size'] = count($v);
        return $ret;
    }

    public function get_log($i)
    {
        $this->check_log();
        $res = $this->select(T_LOG, 'content', 'day=' . $i);
        $v = $res->fetchAll();
        if (count($v) == 0)
            $ret['result'] = "failure";
        else {
            $ret['result'] = "success";
            $ret['content'] = $v[0]['content'];
        }
        return $ret;
    }

    public function update_log($i, $c, $p)
    {
        $this->check_log();
        if ($p != md5('123456789'))
            return array('result' => 'failure');
        $this->update(T_LOG, 'content', "'" . $c . "'", 'day=' . $i);
        return array('result' => 'success');
    }
}
