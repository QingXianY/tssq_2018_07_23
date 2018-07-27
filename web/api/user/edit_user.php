<?php

include_once "../../class/User.php";

$user_id=$_POST['user_id'];
$user_name = isset($_POST['user_name'])?$_POST['user_name']:'';
$user_tel = isset($_POST['user_tel'])?$_POST['user_tel']:'';
$user_pic = isset($_POST['user_pic'])?$_POST['user_pic']:'';
$user_password=isset($_POST['user_password'])?$_POST['user_password']:'';
$user_cardid=isset($_POST['user_cardid'])?$_POST['user_cardid']:'';
$user_location=isset($_POST['user_location'])?$_POST['user_location']:'';
$user=new User();
 echo $user->updateUser($user_id,$user_name,$user_tel,$user_pic,$user_password,$user_cardid,$user_location);