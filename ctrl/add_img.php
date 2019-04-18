<?php

namespace ctrl;

class add_img extends \core\ApiCtrl
{
    public function main()
    {
        global $IMG;
        //检查参数存在性,参数简短化
        $response['result'] = "failure";
        try {
            $_METHOD = $_FILES['file'];
            $_0 = $_METHOD['error'];
            $_1 = $_METHOD['type'];
            $_2 = $_METHOD['size'];
            $_3 = $_METHOD['tmp_name'];
        } catch (\Exception $exception) {
            //必选参数不能为空
            return $response;
        }

        //记录错误日志,日志名:add_img
        if ($_0 != 0) {
            \core\lib\log::log(json_encode($_METHOD), "add_img");
            return $response;
        }

//        //先用请求头的类型进行初步筛选,不要其他类型的
//        if ($_1 !== "image/jpeg" && $_1 !== "image/pjpeg" && $_1 !== "image/png") {
//            $response['result'] = "invalid type";
//            return $response;
//        }

        //把不合法大小的文件筛掉
        if ($_2 > (1 << 30)) {
            $response['result'] = "invalid size";
            return $response;
        }

        //保存文件
        $response['result'] = "success";
        $md5 = md5_file($_3);
        $response['filename'] = $md5;
        $new_file_name = "$IMG/$md5";
        if (!img_exists($md5)) {
            move_uploaded_file($_3, $new_file_name);

            //到文件中查看文件类型
            if (!is_img_file($md5)) {
                unlink($new_file_name);
                $response['result'] = "invalid type";
                unset($response['filename']);
            }
        }
        return $response;
    }
}