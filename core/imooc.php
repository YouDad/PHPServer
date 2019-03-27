<?php

namespace core;

class imooc{
    public static $classMap=array();
    public $assign;


    public static function run(){
        $route=new \core\lib\route();
        $ctrlClass=$route->ctrl;
        $action=$route->action;
        $ctrlFile=CTRL.$ctrlClass.'Ctrl.php';
        if(is_file($ctrlFile)){
            include $ctrlFile;
            $className='\\app\\ctrl\\'.$ctrlClass.'Ctrl';
            $ctrl=new $className();
            $ctrl->$action();
        }else{
            throw new \Exception("Can't find Ctrl".$ctrlClass);
        }
    }

    public static function load($class){
        # auto load class file
        # $class='core\route';
        # IMOOC.'/core/route.php';
        #p('try to load '.$class);
        if(isset($classMap[$class]))
            return true;
        $class=str_replace('\\','/',$class);
        $file=IMOOC.'/'.$class.'.php';
        if(is_file($file)){
            include $file;
            self::$classMap[$class]=$class;
        }else{
            return false;
        }
    }
    
    public function assign($name,$value){
        $this->assign[$name]=$value;
    }

    public function display($file){
        $file = APP.'views/'.$file;
        if(is_file($file)){
            extract($this->assign);
            include $file;
        }
    }
}


