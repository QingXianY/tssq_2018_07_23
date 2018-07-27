<?php

include_once "../../class/ProductType.php";

$type_name = $_POST['type_name'];
$type_remark = $_POST['type_remark'];

$ProductType = new ProductType();
echo $ProductType->addProductType($type_name,$type_remark);

