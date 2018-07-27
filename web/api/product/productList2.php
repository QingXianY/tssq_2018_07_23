<?php

include_once "../../class/Product.php";


$type_id = isset($_GET['type_id'])?$_GET['type_id']:null;
$product_id = isset($_GET['product_id'])?$_GET['product_id']:null;
$product_name = isset($_GET['product_name'])?$_GET['product_name']:null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;


$Product = new Product();


echo $Product->getProductList2($page,$rows,$type_id,$product_id,$product_name);



