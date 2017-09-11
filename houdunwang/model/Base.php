<?php
namespace houdunwang\model;
use PDO;
use PDOException;
use Exception;
class Base
{
//      获取指定的字段
        private $filed='';
//     设置查询结构的数据属性
        private $data;
//      where条件属性
        private $where='';
//      声明操作的数据表table
        protected $talbe;

//      设置静态变量的默认值为空
        private static $pdo=null;
//      设置属性操作数据的表
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
//            1加载数据库
//            2调用函数中c的方法来获得搜索的信息

            $dsn      = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
//            1数据库的用户名
            $user     = c('database.user');
//            数据库密码
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
//    设置排序方法

        public function order($liu,$hong='asc')
        {
//            测试方法能不能引用到
//            echo 1;
            $sql="select * from {$this->data_table}order by {$liu} {$hong}";

            $res=$this->query($sql);
//            设置返回值
            return $res;
        }
//        修改数据方法
        public function  update(array $data)
        {
//            测试能不能引用到修改数据函数
//            echo 1
//           对用户是否添加了修改条件做一下判断
            if(empty($this->where)){
//                如果没有做了修改，那就不用动
                return false;
            }
            //声明一个变量 用于存储被修改字段的值
            $files='';
            //由于我们指定了要修改的数据必须以数组的形式传送 那么传送过来的数据可以通过循环的方式 得到我们想要的
            //的方shi
            foreach ($data as $k=>$v){
                //echo 1;exit;
                //为了防止sql语句因整型或字符串混用而导致的语法错误 在这需对$v 进行下判断
                //判断$v 是否为整型
                if(is_int($v)){
                    $files.="$k='$v'".',';
                    //dd($files);exit;

                }else{
                    $files.="$k='$v'".',';
                    //dd($files);exit;
                }

            }
            //将拼接好的字符串并且将最右侧的逗号去掉
            $files=rtrim($files,',');
            //dd($files);exit;
            //dd($this->where);exit;
            //dd($this->data_table);exit;
            //拼接sql语句{$this->data_table} set{$files} {$this->where}
            $sql="update {$this->data_table} set {$files} {$this->where}";
            //dd($sql);exit;
            //用exec方法进行数据的修改
            $res=$this->exec($sql);
//            输出测验
            //dd($a);exit;
//            设置$res的返回值
            return $res;

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
//            设置统计数据、
        public function count(){
//            拼接搜索查询语句----select * from {$this_table} {$this->where}
        $sql = "select count(*) as total from {$this->table} {$this->where}";
//            1执行sql语句
//            2返回到查询到的结果显示
        $data =  $this->query ($sql);
//        返回数组的total值
        return $data[0]['total'];
        }
        public function field ( $field )
        {
        $this->field = $field;

        return $this;
        }
        public function insert ( $data )
        {
//            测试判断
//            echo 1
        $fields = '';
        $values = '';
//        进行foreach循环 循环每一个单位
        foreach ( $data as $k => $v ) {
            $fields .= $k . ',';
//            对数组的键值进行判断是否存在整形
            if ( is_int ( $v ) ) {
//                数值类型为整形
                $values .= $v . ',';
            } else {
//                数值类型不是整形
                $values .= "'$v'" . ',';
            }
        }
//        将最右侧的逗号删除 rtrim
        $fields = rtrim ( $fields , ',' );
        $values = rtrim ( $values , ',' );
//        拼接sql语句
        $sql = "insert into {$this->table} ({$fields}) values ({$values})";

        //执行sql语句，将数据插入数据库
        return $this->exec ( $sql );
    }

    public function find ( $pk )
    {
        //获取当前操作表的主键
        //获取当前操作表的主键
        $priKey = $this->getPriKey ();
        //dd($priKey);
        //$sql = "select * from 表 where 主键=$pk";
        //组合where语句,调用where方法
        //为了把sql中where条件语句存储到where属性中
        $this->where ( "$priKey={$pk}" );
        $field = $this->field ? : '*';
//        设置变量$sql 将sql语句拼接查询
        $sql = "select {$field} from {$this->table} {$this->where}";
        //调用我们自定义的query方法执行sql语句
        $data = $this->query ( $sql );
        if ( ! empty( $data ) ) {
//            如果不为空九江数值储存到数据库
            $this->data = current ( $data );
//            设置返回值 $this
            return $this;
        }

        return $this;

        return [];
    }
//    将对象转化为数组
    public function toArray ()
    {
//        判断对象是否存在
        if ( $this->data ) {
            return $this->data;
        }

        return [];
    }
//    where 条件判断语句
    public function where ( $where )
    {
//        将where条件 储存到 $this->where中，全局就能调用
        $this->where = "where {$where}";
//        设置返回值
        return $this;
    }
//    删除数据
    public function del($id='')
    {
//        输出测验
//        echo 1
//      设置if判断，判断where是否为空，如果为空会造成误删
//        所以不能让其为空
        if(!empty($this->where)||$id){
            if($id){
                $pk = $this->getPK();
                //调用方法 拼接删除第几条数据的where条件
                $this->where("$pk=$id");
                //dd($this->where);exit;
                //构造删除数据的sql语句 {$this->data_table} {$this->where}
                $sql = "delete from {$this->data_table} {$this->where}";
            }else{
                //如果没有变量$id 就执行用户传递的筛选条件进行删除
                $sql = "delete from {$this->data_table} {$this->where}";
            }


            return $this->exec($sql);

        }else{
            //返回一个false 禁止用户操作数据库数据
            return false;
            }
    }







}