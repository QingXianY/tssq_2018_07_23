<?php

include_once "../../class/Service.php";

$user_id = $_POST['user_id'];
$volunteer_id = $_POST['volunteer_id'];
$service_id = $_POST['service_id'];

$Service=new Service();

echo $Service->addServiceOrder($user_id,$volunteer_id,$service_id);