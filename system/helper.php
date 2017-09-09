<?php
/**
 * 助手函数
 */
//头部
header ('Content-type:text/html;charset=utf8');
//设置时区
date_default_timezone_set('PRC');

/**
 * 定义常量判断是否为post请求
 */
define ('IS_POST',$_SERVER['REQUEST_METHOD']=='POST'?true:false);

if(!function_exists ('dd')){
	/**
	 * 打印函数
	 */
	function dd($var){
		echo '<pre style="background: #ccc;padding: 8px;border-radius: 5px">';
		//print_r打印函数，不显示数据类型
		//print_r不能打印null，boolen
		if(is_null ($var)){
			var_dump ($var);
		}elseif(is_bool ($var)){
			var_dump ($var);
		}else{
			print_r ($var) ;
		}
		echo '</pre>';
	}
}
    function c ($path)
    {
        $info =explode('.',$path);
        $config =include "../system/config/". $info[0].'.php';
        return isset($config[$info[1]])? $config[$info[1]]:null;

    }

