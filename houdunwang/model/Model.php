<?php

namespace houdunwang\model;

class Model
{
    public function __call ( $name , $arguments )
    {
        return self::parseAction ( $name , $arguments );
    }

    public static function __callStatic ( $name , $arguments )
    {
        return self::parseAction ( $name , $arguments );
    }

    public static function parseAction ( $name , $argument )
    {
        $class = get_called_class ();
        return call_user_func_array ( [ new Base($class) , $name ] , $argument );
    }
}