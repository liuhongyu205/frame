<?php
namespace houdunwang\model;
use PDO;
use PDOException;
use Exception;
class Base
{
//    设置静态变量的默认值为空
    private static $pdo=null;
//    设置属性操作数据的表
    private $table;
    public function __construct($class)
    {
//        1连接数据库
//        2当数据库为空时
        if (is_null(self::$pdo)) {
            self::connect();
        }
        $info = strtolower(Itrim(strrchr($class, '\\'), '\\'));
    }
        private static function connect ()
    {
        try {
            $dsn      = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
            $user     = c('database.user');
            $password = c('database.password');
            self::$pdo      = new PDO( $dsn , $user , $password );
            //设置字符集
            self::$pdo->query ('set names utf8');
            //设置错误属性
            self::$pdo->setAttribute (PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch ( PDOException $e ) {
            throw new Exception($e->getMessage ());
        }
    }

        public function find ($id)
    {
        //先获取主键，获取当前操作的数据表的主键到底是谁
        $pk = $this->getPk();
        //dd($this->table);
        $sql = "select * from {$this->table} where {$pk} = {$id}";
        //dd($sql);
        //执行查询
        $data = $this->query ($sql);
        //dd($data);
        return current ($data);
    }


//        获取表主键到底是id还是aid还是cid

        private function getPk(){
        //查看表结构
        $sql = "desc " . $this->table;
        $data  = $this->query ($sql);
        //dd($data);
        $pk = '';
        foreach($data as $v){
            if($v['Key'] == 'PRI'){
                $pk = $v['Field'];
                break;
            }
        }
        return $pk;
    }

//         执行有结果集的查询

        public function query($sql){
        try{
            $res = self::$pdo->query($sql);
            //去除结果集做一个关联数组
            return $row = $res->fetchAll(PDO::FETCH_ASSOC);
             }catch (PDOException $e){
                throw new Exception($e->getMessage ());
                }
        }



}