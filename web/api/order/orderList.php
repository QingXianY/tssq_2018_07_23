<?php

include_once "../../class/Order.php";

$order_code = isset($_GET['order_code'])?$_GET['order_code']:'';
$volunteer_id = isset($_GET['volunteer_id'])?$_GET['volunteer_id']:'';
$order_status = isset($_GET['order_status'])?$_GET['order_status']:'';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
$start_date = isset($_GET['start_date'])?$_GET['start_date']:null;
$end_date = isset($_GET['end_date'])?$_GET['end_date']:null;

$Order = new Order();


echo $Order->getOrderList($page,$rows,$order_code,$order_status,$volunteer_id,$start_date,$end_date);



