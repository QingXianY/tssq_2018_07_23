<?php
include_once "../../class/Service.php";


$service_name=$_POST['service_name'];
$service_content=$_POST['service_content'];
$service_integral=$_POST['service_integral'];

$service=new Service();
echo $service->addService($service_name,$service_content,$service_integral);