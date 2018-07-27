<?php
header("Content-type:text/html;charset=utf-8");
class wxApi{
    private $app_id="wx8f02afc8eabc8ab9";
    private $appsecret="961d8e489a510826bc0a8432ce88fafb";

    public function __construct(){
        date_default_timezone_set('PRC');
    }
    public function get_access_token_new(){
        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->app_id . "&secret=" . $this->appsecret;
        $res = file_get_contents($token_access_url);    //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true);   //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        $result['expire_time']=time() + 7190;
        return $result;
    }
    public function get_access_token(){
        session_start();
        if(!isset($_SESSION['data'])){
            $result=$this->get_access_token_new();
            $_SESSION['data']=json_encode($result);
            return $result['access_token'];
        }else{
            $data=json_decode($_SESSION['data']);
            if($data->expire_time < time()){
                $result=$this->get_access_token_new();
                $result['expire_time']=time() + 7190;
                $_SESSION['data']=json_encode($result);
                return $result['access_token'];
            }else{
                return $data->access_token;
            }
        }
    }
    public function get_user_msg($code){
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=" . $this->app_id . "&secret=".$this->appsecret."&js_code=".$code."&grant_type=authorization_code";
        $res = file_get_contents($url);    //获取文件内容或获取网络请求的内容
        $result = json_decode($res, true);   //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
        return $result;
    }
}