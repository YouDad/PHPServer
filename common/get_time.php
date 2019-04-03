<?php
/**
 * @return int
 * 返回秒级的时间
 */
function get_time()
{
    date_default_timezone_set("Asia/Shanghai");
    $zero1 = strtotime(date("y-m-d h:i:s"));
    $zero2 = strtotime("2000-01-01 00:00:00");
    return ($zero1 - $zero2);
}

function get_server_time()
{
    date_default_timezone_set("Asia/Shanghai");
    $zero1 = strtotime(date("y-m-d h:i:s"));
    $zero2 = strtotime("1970-01-01 00:00:00");
    return ($zero1 - $zero2) + 14400;
}