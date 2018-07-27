<?php
include_once "../../class/Service.php";

$service_id=$_POST['service_id'];
$service_name=$_POST['service_name'];
$service_content=$_POST['service_content'];
$service_integral=$_POST['service_integral'];

$service=new Service();
echo $service->modifyService($service_id,$service_name,$service_content,$service_integral);