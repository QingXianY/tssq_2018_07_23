<?php 
include_once "../../class/Service.php";



$user_id=$_POST['user_id'];
$service_id=$_POST['service_id'];
$service=new Service();
echo $service->submitApplication($user_id,$service_id);