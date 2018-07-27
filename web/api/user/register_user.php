<?php

include_once "../../class/User.php";
include_once "../../../config/db_config.php";


$user_name = $_POST['user_name'];
$user_tel = $_POST['user_tel'];
$message_code = $_POST['message_code'];
$ts=$_POST['ts'];
$user_pic=$_POST['user_pic'];
$user_cardid=$_POST['user_cardid'];
$user_location=$_POST['user_location'];
$user_password=$_POST['user_password'];

$selectMessage = "select * from tmp_message where message_code='$message_code' and ts='$ts'";
$connect= db_config::getInstance();
$conn=$connect->connect_bdb();
$message_code=$conn ->query($selectMessage);
if(!$message_code -> fetch_assoc()){
	echo $connect -> out_msg(2,'验证码错误，注册失败','');
	exit;
}
$user=new User();
if($user->selectUserByTel($user_tel)){
	echo $connect -> out_msg(0,'该手机号已注册','');
	exit;
}

 echo $user->register_user($user_name,$user_tel,$user_pic,$user_cardid,$user_location,$user_password);