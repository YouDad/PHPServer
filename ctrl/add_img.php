<?php

namespace app\ctrl;

class add_img extends \core\ApiCtrl
{
    public function main()
    {
        $file = $_FILES['file'];
        $_1 = $file['error'];
        $_2 = $file['type'];
        $_3 = $file['size'];
        $_4 = $file['tmp_name'];
        //$_5 = $file['name'];
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
            if (!$this->is_img_file($new_file_name)) {
                unlink($new_file_name);
                $response['result'] = "invalid type";
                unset($response['filename']);
            }
        }
        return $response;
    }

    private function is_img_file($file_name)
    {
        $fp = fopen($file_name, "rb");
        if (!$fp) {
            return false;
        }
        $bytes6 = fread($fp, 6);
        fclose($fp);
        if ($fp) {
            if ($bytes6 === false) {
                return false;
            }
            if (substr($bytes6, 0, 3) == "\xff\xd8\xff") {
                //return "image/jpeg";
                return true;
            }
            if ($bytes6 == "\x89PNG\x0d\x0a") {
                //return "image/png";
                return true;
            }
            if ($bytes6 == "GIF87a" || $bytes6 == "GIF89a") {
                //return "image/gif";
                return true;
            }
            return false;
        }
        return false;
    }
}