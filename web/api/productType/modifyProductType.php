<?php

include_once "../../class/ProductType.php";

$type_id = $_POST['type_id'];
$type_name = $_POST['type_name'];
$type_remark = $_POST['type_remark'];

$ProductType = new ProductType();

echo $ProductType->modifyProductType($type_id,$type_name,$type_remark);

