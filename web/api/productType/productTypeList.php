<?php

include_once "../../class/ProductType.php";

$type_name = isset($_GET['type_name'])?$_GET['type_name']:null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;

$ProductType = new ProductType();

echo $ProductType->getProductTypeList($page,$rows,$type_name);

