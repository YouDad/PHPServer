<?php

namespace ctrl;

class add_img extends \core\ApiCtrl
{
    public function main()
    {
        $file = $_FILES['file'];
        $_1 = $file['error'];
        $_2 = $file['type'];
        $_3 = $file['size'];
        $_4 = $file['tmp_name'];
        $response['result'] = "failure";

        if ($_1 != 0) {
            \core\lib\log::log(json_encode($file), "add_img");
            return $response;
        }

        if ($_2 !== "image/jpeg" && $_2 !== "image/pjpeg" && $_2 !== "image/png") {
            $response['result'] = "invalid type";
            return $response;
        }

        if ($_3 > (1 << 30)) {
            $response['result'] = "invalid size";
            return $response;
        }

        $response['result'] = "success";
        $md5 = md5_file($_4);
        $response['filename'] = $md5;
        $new_file_name = APIS . "img/" . $md5;
        if (!file_exists($new_file_name)) {
            move_uploaded_file($_4, $new_file_name);
            if (!is_img_file($md5)) {
                unlink($new_file_name);
                $response['result'] = "invalid type";
                unset($response['filename']);
            }
        }
        return $response;
    }
}