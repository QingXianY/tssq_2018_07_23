<?php

include_once "../../class/Product.php";

$product_id = $_GET['product_id'];

$Product = new Product();

echo $Product->deleteProduct($product_id);