<?php

include_once "../../class/User.php";
include_once "../../../config/db_config.php";


$user_name = $_POST['user_name'];
$user_tel = $_POST['user_tel'];
$user_pic=$_POST['user_pic'];
$user_cardid=$_POST['user_cardid'];
$user_location=$_POST['user_location'];
$user_password=$_POST['user_password'];

$user=new User();
if($user->selectUserByTel($user_tel)){
	echo $connect -> out_msg(0,'该手机号已注册','');
	exit;
}

 echo $user->register_user($user_name,$user_tel,$user_pic,$user_cardid,$user_location,$user_password);