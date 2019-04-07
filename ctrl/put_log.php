<?php

namespace ctrl;

class put_log extends \core\ApiCtrl
{
    public function main()
    {
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['i'];
            $_1 = $_METHOD['c'];
            $_2 = $_METHOD['p'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //判断口令是否正确
        $res = model("Log")->update_log($_0, $_1, $_2);
        if (!$res) {
            return $response;
        }

        //更新日志
        $response['result'] = "success";
        $res = model("Log")->get_log($_0);
        $response['content'] = $res;
        return $response;
    }
}
