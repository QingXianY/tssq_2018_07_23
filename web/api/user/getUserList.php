<?php

include_once "../../class/User.php";

$user_tel = isset($_GET['user_tel'])?$_GET['user_tel']:null;
$user_name = isset($_GET['user_name'])?$_GET['user_name']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;


$User=new User();

echo $User->getUserList($page,$rows,$user_name,$user_tel);