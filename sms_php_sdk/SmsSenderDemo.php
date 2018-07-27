<?php

require_once "SmsMultiSender.php";//短信群发
require_once  "SmsSingleSender.php";//短信单发
require_once  "SmsVoiceVerifyCodeSender.php";//语音验证码发送
require_once  "SmsVoicePromptSender.php";//语音通知发送

use Sms\SmsSingleSender;
use Sms\SmsMultiSender;
use Sms\SmsVoicePromptSender;
use Sms\SmsVoiceVerifyCodeSender;



try {
    // 请根据实际 appid 和 appkey 进行开发，以下只作为演示 sdk 使用
    $appid = 140009813705;
    $appkey = "892138c566adaebff29a866468715746";
    $phoneNumber1 = "18271691955";
    $phoneNumber2 = "18271691955";


    $singleSender = new SmsSingleSender($appid, $appkey);

    // 普通单发
    $result = $singleSender->send(0, "86", $phoneNumber2, "【斑羚在线】测试短信字数：70字。测试短信字数：70字。测试短信字数：70字。测试短信字数：70字。测试短信字数：70字。测试短信字数：7","");
    $rsp = json_decode($result);
    echo $result;
    echo "<br>";


    // 指定模板单发
    // 假设模板内容为：{1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。
    $params = array("1234", "2");
    $templId=25691;
    $sign='斑羚在线';
    $result = $singleSender->sendWithParam("86", $phoneNumber2, $templId, $params,$sign,"");
    $rsp = json_decode($result);
    echo $result;
    echo "<br>";

    $multiSender = new SmsMultiSender($appid, $appkey);

    // 普通群发
    $phoneNumbers = array($phoneNumber1, $phoneNumber2);
    $result = $multiSender->send(1, "86", $phoneNumbers, "宝马专场特卖会 6月24.25日燕宝携手天津港最大宝马经销商要掀起一场（宝马X5 X6）低价风暴,60万就能买到宝马X5,X6 ,凡到店者即有好礼相送,活动地址：洛阳市涧西区中泰世纪花城洛阳燕宝汽车展厅 电话：64380777回T退订", "");
    $rsp = json_decode($result);
    echo $result;
    echo "<br>";


     // 指定模板群发，模板参数沿用上文的模板 id 和 $params
     
    $result = $multiSender->sendWithParam("86", $phoneNumbers, $templId, $params, $sign, "");
    $rsp = json_decode($result);
    echo $result;
    echo "<br>";

    //语音验证码发送
    $voiceVeriyCodeSender = new SmsVoiceVerifyCodeSender($appid,$appkey);
    $result = $voiceVeriyCodeSender->send("86",$phoneNumber1,"1234",2,"");
    $rsp = json_decode($result);
    echo $result;
    echo "<br>";

    //语音通知发送
    $voicePromptSender = new SmsVoicePromptSender($appid,$appkey);
    $result = $voicePromptSender->send("86",'xxxxxxxxxxx',2,"您好，你正在登录营业厅官方网站，请您确认是否本人登录，如不是请尽快修改密码！",2,"");
    $rsp = json_decode($result);
    echo $result;
    echo "<br>";




 

} catch (\Exception $e) {
    echo var_dump($e);
}
