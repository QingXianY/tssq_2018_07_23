<?php

include_once "../../class/Product.php";

$type_id = $_POST['type_id'];
$product_name = $_POST['product_name'];
$product_pic = $_POST['product_pic'];
$product_price = $_POST['product_price'];
$product_description = $_POST['product_description'];
$product_storage = $_POST['product_storage'];
$product_content = $_POST['product_content'];



$Product=new Product();

echo $Product->addProduct($type_id,$product_name,$product_pic,$product_price,$product_description,$product_storage,$product_content);