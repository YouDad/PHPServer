<?php

namespace ctrl;

class for_test extends \core\ApiCtrl
{
    public function main()
    {
        $db = model();
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        $_METHOD = $_POST;
        try {
            $_0 = $_METHOD['function'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }
        switch ($_0) {
            case "delete_user":
                $db->delete(\core\lib\model\T_USER, "username='1'");
                break;
            case "create_user":
                if (!model('User')->get_uid("1")) {
                    model('User')->add_user('1', 'b7db24c0221fe9af2945aef4bbf92e94');
                }
                break;
            default:
                $response['result'] = "no function";
                return $response;
        }
        $response['result'] = "success";
        return $response;
    }
}
