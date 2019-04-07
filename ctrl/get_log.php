<?php

namespace ctrl;

class get_log extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "success";
        $_METHOD = $_GET;

        //可选参数赋值
        $_0 = null;
        if (isset($_METHOD['i']) && $_METHOD['i'] !== "") $_0 = $_METHOD['i'];

        //获得日志个数
        $size = model("Log")->get_size();

        if ($_0 === null) {
            $response['size'] = $size;
        } else {
            if ($size === 0) {
                $response['result'] = "failure";
            } else {
                $res = model("Log")->get_log($_0);
                if ($res) {
                    $response['content'] = $res;
                } else {
                    $response['result'] = "invalid i";
                }
            }
        }
        return $response;
    }
}
