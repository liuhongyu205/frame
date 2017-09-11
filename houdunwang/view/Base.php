<?php
namespace houdunwang\view;
class Base
{
   protected $data=[];
   protected $file;
    public function make(){
        $this->file="../app/".MODULE."/view/".strtolower(CONTROLLER)."/".ACTION.".".c('view.suffix');
        return $this;
    }
    public function __toString()
    {
        extract($this->data);
        include $this->file;
//        返回字符串 否则会报错
        return '';
    }
    public function with($var){
        $this->data=$var;
        return $this;
    }
}