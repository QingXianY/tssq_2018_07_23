<?php 
include_once "../../class/Service.php";


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;

$user_name=isset($_GET['user_name'])?$_GET['user_name']:'';
$volunteer_name=isset($_GET['volunteer_name'])?$_GET['volunteer_name']:'';
$service_id=isset($_GET['service_id'])?$_GET['service_id']:'';
$start_time=isset($_GET['start_time'])?$_GET['start_time']:'';
$end_time=isset($_GET['end_time'])?$_GET['end_time']:'';
$order_status=isset($_GET['order_status'])?$_GET['order_status']:'';



$service=new Service();
echo $service->getServiceOrderList($user_name,$volunteer_name,$service_id,$start_time,$end_time,$order_status,$page,$rows);