<?php

include_once "../../class/Detail.php";


$volunteer_id = $_GET['volunteer_id'];
$detail_type=isset($_GET['detail_type'])?$_GET['detail_type']:'';
$start_date = isset($_GET['start_date'])?$_GET['start_date']:null;
$end_date = isset($_GET['end_date'])?$_GET['end_date']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;

$Detail = new Detail();
echo $Detail->getDetailList($page,$rows,$volunteer_id,$detail_type,$start_date,$end_date);

