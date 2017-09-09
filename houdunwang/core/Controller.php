<?php
//1建立命名空间
//2 命名空间的名称为文件所在的路径，作用是
//①、实现便捷加载，封装事物
//②、防止编码与php内部类、函数、常量、或者第三方的类、常量之间的名字冲突
//③、为类创建一个别名，提高源码的可读性
namespace houdunwang\core;
//建立封装Controller类用于网页的跳转
class Controller
{
//          1设置私有属性$url
//          2该属性用于下文跳转链接的使用
    private $url="window.history.back()";
//          1设置信息函数
    protected function message($message){
//          引入至模版页面
//          看到提示页面后进行三秒后的跳转、
    include "./view/message.php";
//          后续操作
    exit();
    }

    protected  function  setRedriect($url=''){
        if($url){
//            跳转本地连接
            $this->url="location.href='$url'";

        }else{
//            如果三秒后跳转不成功则，链接跳转至上一个历史界面
            $this->url="window.history.b1ack()";
        }
        return $this;

    }


}