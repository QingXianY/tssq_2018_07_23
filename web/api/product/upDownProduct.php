<?php

include_once "../../class/Product.php";

$product_id = $_POST['product_id'];
$product_status = $_POST['product_status'];

$Product=new Product();

echo $Product->upDownProduct($product_id,$product_status);

