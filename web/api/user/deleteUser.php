<?php

include_once "../../class/User.php";
include_once "../../../config/db_config.php";


$user_id = $_POST['user_id'];

$user=new User();

echo $user->deleteUser($user_id);