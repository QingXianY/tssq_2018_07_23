<?php

include_once "../../class/User.php";

$volunteer_id=$_GET['volunteer_id'];
$user=new User();
echo $user->selectById1($volunteer_id);