<?php

include_once "../../class/Order.php";

$order_code = $_GET['order_code'];

$Order=new Order();

echo $Order-> checkOrder($order_code);