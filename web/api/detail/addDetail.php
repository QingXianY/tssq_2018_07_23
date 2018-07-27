<?php

include_once "../../class/Detail.php";

$student_id = $_POST['student_id'];
$detail_content = $_POST['detail_content'];
$detail_type = $_POST['detail_type'];
$detail_value = $_POST['detail_value'];
$detail_date = $_POST['detail_date'];

$Detail=new Detail();

echo $Detail->addDetail($student_id,$detail_content,$detail_type,$detail_date);