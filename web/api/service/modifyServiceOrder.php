<?php

include_once "../../class/Service.php";

$order_code = $_POST['order_code'];
$volunteer_id = $_POST['volunteer_id'];
$service_id = $_POST['service_id'];

$Service=new Service();

echo $Service->modifyServiceOrder($order_code,$volunteer_id,$service_id);