<?php

include_once "../../class/User.php";
include_once "../../../config/db_config.php";

$flag=$_POST['flag'];
$volunteer_name = $_POST['volunteer_name'];
$volunteer_tel = $_POST['volunteer_tel'];
$message_code = $_POST['message_code'];
$ts=$_POST['ts'];
$volunteer_pic=$_POST['volunteer_pic'];
$volunteer_password=$_POST['volunteer_password'];
$volunteer_pro=$_POST['volunteer_pro'];
$volunteer_motto=$_POST['volunteer_motto'];


$selectMessage = "select * from tmp_message where message_code='$message_code' and ts='$ts'";
$connect= db_config::getInstance();
$conn=$connect->connect_bdb();
$message_code=$conn ->query($selectMessage);
if(!$message_code -> fetch_assoc()){
	echo $connect -> out_msg(2,'验证码错误，注册失败','');
	exit;
}
$user=new User();
if($user->selectVolunteerByTel($volunteer_tel)){
	echo $connect -> out_msg(0,'该手机号已注册','');
	exit;
}

 echo $user->register_volunteer($flag,$volunteer_name,$volunteer_tel,$volunteer_pic,$volunteer_password,$volunteer_pro,$volunteer_motto);