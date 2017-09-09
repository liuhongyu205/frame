<?php
//设置命名空间  名称是 文件所在路径----app\home\controller
namespace app\home\controller;
//一建立Entry类，
//二用于默认参数输出
use houdunwang\core\Controller;
use houdunwang\view\View;

//use houdunwang\view\View;
//use system\model\Article;

class Entry extends Controller{

//    类内建立公共函数index
//        输出验证
    public function index(){
//       测试函数C是否正常
//        echo 1;
        $user=c('database.host');
//        dd($user);
        return View::with(compact ('test'))->make();
    }
    public function store(){
        $this->setRedriect('?s=home/entry/index')->message('添加成功');
    }
}