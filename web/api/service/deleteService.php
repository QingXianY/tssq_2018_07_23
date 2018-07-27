<?php
include_once "../../class/Service.php";

$service_id=$_POST['service_id'];

$service=new Service();
echo $service->deleteService($service_id);