<?php
//1设置命名空间名为文件所在目录 houdunwang\core
//2命名空间的作用是
//①实现便捷加载,封装事物
//②防止编码与php内部类/函数/常量或者第三方的类/常量/之间的名字冲突
//③为类创建一个别名，阿里提高源码的可读性
namespace houdunwang\core;
include '../system/helper.php';
class Boot
{

   public static function run(){
//       echo 'hahahah';
//       1初始化框架
       self::init();
//       2执行应用
//       /s=home/entry/add
       self::appRun();
//       3.运行异常抛出
       self::handler();
   }
//   初始化框架函数
    public static function init()
    {
        //1声明头部
        //2.头部的作用是，防止浏览器输出出现乱码
//        header('Content-type:text/html;charset=utf8');
        header ( 'Content-type:text/html;charset=utf8' );
        //1设置时区'prc'
//        2设置时区的作用是防止在以后操作中当使用时间时出现错误。
        date_default_timezone_set('PRC');
        //1开始session
        //2.session开启才可以使用，所以session_id则不再重复开启session
        session_id()||session_start();

    }
    public static function appRun(){
//       地址栏获得参数's'
       if(isset($_GET['s'])){
//       s参数包含有 home(模块)/entry(控制器)/index(方法)
//       dd($_GET['s']);
        $info=explode('/',$_GET['s']);
//       dd($info);
//        做地址栏参数带入
//        $info[0]=home,$info[1]=entry
        $class="\app\\{$info[0]}\controller\\".ucfirst($info[1]);
//        行动函数$info[2]=index;
        $action=$info['2'];
//        定义常量
        define('MODULE',$info[0]);
        define('CONTROLLER',$info[1]);
        define('ACTION',$info[2]);
        }
//        地址栏没有参数s所以需要个默认值
        else{
           $class="\app\home\controller\Entry";
           $action='index';
//           定义变量
            define('MODULE','home');
            define('CONTROLLER','entry');
            define('ACTION','index');
        }
//            调用参数，实例化类与(new $class)->action();相似
            echo call_user_func_array([new $class,$action],[]);



    }
//    抛出异常函数
    private static function handler(){
        $whoops=new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();

    }

}