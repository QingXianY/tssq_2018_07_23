<?php

include_once "../../class/User.php";
include_once "../../../config/db_config.php";

$flag=$_POST['flag'];
$volunteer_name = $_POST['volunteer_name'];
$volunteer_tel = $_POST['volunteer_tel'];
$volunteer_pic=$_POST['volunteer_pic'];
$volunteer_password=$_POST['volunteer_password'];
$volunteer_pro=$_POST['volunteer_pro'];
$volunteer_motto=$_POST['volunteer_motto'];


$user=new User();
if($user->selectVolunteerByTel($volunteer_tel)){
	echo $connect -> out_msg(0,'该手机号已注册','');
	exit;
}

 echo $user->register_volunteer($flag,$volunteer_name,$volunteer_tel,$volunteer_pic,$volunteer_password,$volunteer_pro,$volunteer_motto);