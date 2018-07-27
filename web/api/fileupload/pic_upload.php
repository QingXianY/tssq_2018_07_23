<?php
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
include_once "../../../config/file.php";


$image_file=$_FILES['file'];//得到传输的数据
$file=new file();
$result = $file->upload_image_file($image_file,"../../images/pic/",time(),'https://wx.xingda188.com/tssq_2018_07_23/web/images/pic/');

echo json_encode($result);
