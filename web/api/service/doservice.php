<?php 
include_once "../../class/Service.php";


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
$user_id=$_GET['user_id'];
$service_name=isset($_GET['service_name'])?$_GET['service_name']:'';
$status=$_GET['status'];
$volunteer_id=isset($_GET['volunteer_id'])?$_GET['volunteer_id']:'';
$service=new Service();
echo $service->getDoserviceList($user_id,$service_name,$status,$volunteer_id,$page,$rows);