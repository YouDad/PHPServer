<?php

/**
 * 返回名叫name的model
 * @param string $name
 * @return mixed
 */
function model($name)
{
    $className = "\\core\\lib\\model\\" . $name . "Model";
    return $className::getIns();
}

/**
 * 返回秒级的时间
 * @return int
 */
function get_time()
{
    date_default_timezone_set("Asia/Shanghai");
    $zero1 = strtotime(date("y-m-d h:i:s"));
    $zero2 = strtotime("2000-01-01 00:00:00");
    return ($zero1 - $zero2);
}

/**
 * 返回当前时间戳
 * @return int
 */
function get_server_time()
{
    date_default_timezone_set("Asia/Shanghai");
    $zero1 = strtotime(date("y-m-d h:i:s"));
    $zero2 = strtotime("1970-01-01 00:00:00");
    return ($zero1 - $zero2) + 14400;
}

/**
 * 返回访问者的ip地址
 * @return string
 */
function get_ip()
{
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res = 'unknown';
    if (isset($ip)) {
        $res = preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches [0] : '';
    }
    return $res;
}

/**
 * 根据$var是否是null来返回 ''或$str
 * @param mixed $var 需要判断的变量
 * @param string $format 如果变量不空返回的字符串格式
 * @param null $args
 * @param null $_
 * @return string
 */
function reserve($var, $format, $args = null, $_ = null)
{
    if ($var === null) {
        return '';
    } else {
        return sprintf($format, $args, $_);
    }
}