<?php

include_once "../../class/ProductType.php";

$type_id = $_GET['type_id'];


$ProductType = new ProductType();

echo $ProductType->deleteProductType($type_id);