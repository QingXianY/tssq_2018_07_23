<?php
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
include_once "../../../config/file.php";


$image_file=$_FILES['file'];//得到传输的数据
$file=new file();
$result = $file->upload_image_file($image_file,"../../images/lunbo/",time(),'https://wx.xingda188.com/xyn_2018_06_18/web/images/lunbo/');

echo json_encode($result);
