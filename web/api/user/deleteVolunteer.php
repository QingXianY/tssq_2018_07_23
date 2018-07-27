<?php

include_once "../../class/User.php";
include_once "../../../config/db_config.php";


$volunteer_id = $_POST['volunteer_id'];

$user=new User();

echo $user->deleteVolunteer($volunteer_id);