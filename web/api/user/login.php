<?php

include_once "../../class/User.php";

$user_tel = $_POST['user_tel'];
$user_password = $_POST['user_password'];
$User=new User();

echo $User->login($user_tel,$user_password);