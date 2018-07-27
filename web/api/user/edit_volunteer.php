<?php

include_once "../../class/User.php";

$volunteer_id=$_POST['volunteer_id'];
$volunteer_name = isset($_POST['volunteer_name'])?$_POST['volunteer_name']:'';
$volunteer_tel = isset($_POST['volunteer_tel'])?$_POST['volunteer_tel']:'';
$volunteer_pic = isset($_POST['volunteer_pic'])?$_POST['volunteer_pic']:'';
$volunteer_password=isset($_POST['volunteer_password'])?$_POST['volunteer_password']:'';
$volunteer_pro=isset($_POST['volunteer_pro'])?$_POST['volunteer_pro']:'';
$volunteer_motto=isset($_POST['volunteer_motto'])?$_POST['volunteer_motto']:'';
$volunteer_assessment=isset($_POST['volunteer_assessment'])?$_POST['volunteer_assessment']:'';
$volunteer_integral=isset($_POST['volunteer_integral'])?$_POST['volunteer_integral']:'';
$user=new User();
 echo $user->updateVolunteer($volunteer_id,$volunteer_name,$volunteer_tel,$volunteer_pic,$volunteer_password,$volunteer_pro,$volunteer_motto,$volunteer_assessment,$volunteer_integral);