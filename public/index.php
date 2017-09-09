<?php
//1引入自动加载
//2加载composer的autoload.php文件
include '../vendor/autoload.php';
//1引入静态变量
//2引入在后盾网文件下的core的Boot类的run方法
\houdunwang\core\Boot::run();
//'houdunwang\core\Boot'