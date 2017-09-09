<?php
namespace houdunwang\view;
class View
{
    public  function _call($name,$arguments){
        return self::parseAction($name,$arguments);
    }
    public static function __callStatic($name,$arguments){
        return self::parseAction($name,$arguments);
    }
    public static function parseAction($name,$arguments)
    {
        return call_user_func_array([new Base,$name],$arguments);
    }
}