<?php

include_once "../../class/Service.php";

$order_code = $_POST['order_code'];
$order_status = $_POST['order_status'];

$Service=new Service();

echo $Service->deleteServiceOrder($order_code,$order_status);