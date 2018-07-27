<?php

include_once "../../class/Detail.php";

$detail_id = $_GET['detail_id'];

$Detail = new Detail();

echo $Detail->deleteDetail($detail_id);