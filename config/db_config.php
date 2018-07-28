<?php
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
class db_config{
    private $host="118.24.45.235";
    private $user="xingda2018";
    private $password="123456";
    private $bdb="xd_tssq";
    protected static $conn;

//    public function __construct(){
//        date_default_timezone_set('PRC');
//    }

    static function getInstance(){
        if( !self::$conn){
            self::$conn = new db_config();
        }
        return self::$conn;
    }
//    public function __destruct(){
//        $this->conn -> close();
//    }
    //连接到用户数据库
    public function connect_bdb(){
        $this->conn=new mysqli($this->host, $this->user, $this->password, $this->bdb);
        $this->conn -> query("set names utf8");
        return $this->conn;
    }

    //操作sql返回结果
    public function doSelectSql($connect,$sql){
        $conn=$connect->connect_bdb();
        $rs = $conn ->query($sql);
        $conn -> close();
        return $rs;
    }
    //操作sql返回结果
    public function doChangeSql($connect,$sql){
        $conn=$connect->connect_bdb();
        $conn ->query($sql);
        $rs = mysqli_affected_rows($conn);
        $conn -> close();
        return $rs;
    }

    //统一返回数据
    public function  out_msg($status='',$msg='',$data=''){
        $out_msg= array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        );
        return json_encode($out_msg);
    }
    //统一返回数据
    public function  out_msg2($status='',$msg='',$count='',$data=''){
        $out_msg= array(
            'status' => $status,
            'msg' => $msg,
            'count' => $count,
            'data' => $data
        );
        return json_encode($out_msg);
    }
}