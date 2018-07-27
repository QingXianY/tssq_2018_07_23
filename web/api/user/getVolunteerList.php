<?php

include_once "../../class/User.php";

$volunteer_name = isset($_GET['volunteer_name'])?$_GET['volunteer_name']:null;
$volunteer_tel = isset($_GET['volunteer_tel'])?$_GET['volunteer_tel']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;


$User=new User();

echo $User->getVolunteerList($page,$rows,$volunteer_name,$volunteer_tel);