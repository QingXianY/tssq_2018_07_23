<?php

include_once "../../class/Order.php";

$volunteer_id = $_POST['volunteer_id'];
$product_id = $_POST['product_id'];

$Order=new Order();

echo $Order->addOrder($volunteer_id,$product_id);