<?php
namespace app\ctrl;
/*
class indexCtrl{
    public function index(){
        p('it is index');
        $model=new \core\lib\model();
        $sql="select * from mysql.help_keyword where help_keyword_id<100;";
        $ret=$model->query($sql);
        p($ret->fetchAll());
    }
}
*/

class indexCtrl extends \core\imooc{
    public function index(){
        $data='Hello World';
        $this->assign('data',$data);
        $this->display('index.html');
    }
}
