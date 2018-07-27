<?php 
include_once "../../class/Service.php";


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
$user_id=$_GET['user_id'];
$service_name=isset($_GET['service_name'])?$_GET['service_name']:'';
$service=new Service();
echo $service->getApplyserviceList($user_id,$service_name,$page,$rows);