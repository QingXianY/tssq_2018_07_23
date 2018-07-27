<?php


require_once    "../../../sms_php_sdk/SmsSingleSender.php";//短信单发
include_once "../../../config/db_config.php";;
use Sms\SmsSingleSender;


try {

    $appid = 140009813705;
    $appkey = "892138c566adaebff29a866468715746";
    $phoneNumber = $_GET['user_tel'];
    $singleSender = new SmsSingleSender($appid, $appkey);
    // 指定模板单发
    // 假设模板内容为：{1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。
    $randCode = rand(1000,9999);  //随机生成验证码
    $params = array($randCode, "3");
    $templId=146393;
    $sign='兴达科技';
    $result = $singleSender->sendWithParam("86", $phoneNumber, $templId, $params,$sign," ");
    $ts=time();
    $message_sql="insert into tmp_message(message_code,ts) values ('$randCode','$ts')";
    $connect= db_config::getInstance();
    $conn=$connect->connect_bdb();
    $conn ->query($message_sql);

     $result = json_decode($result);
     $result->ts=$ts;
     $result=json_encode($result);
     echo $result;
     
     
    
} catch (\Exception $e) {
    echo var_dump($e);
}
