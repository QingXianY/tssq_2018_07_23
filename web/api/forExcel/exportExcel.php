<?php
include_once "../../../config/db_configa.php";
include_once "../../../config/get_time.php";
$connect=new connect();
$get_time=new get_time();
$conn = $connect -> connect_bdb();

header("Content-type: text/html;charset=utf-8");
//检查权限 04=导出
require_once("../../../phpexcel/PHPExcel.php");
include("../../../phpexcel/PHPExcel/IOFactory.php");


$sql="select * from v_bill_detail";
$rs=$conn -> query($sql);


//创建一个excel对象
$objPHPExcel = new PHPExcel();

// Set properties  设置文件属性
$objPHPExcel->getProperties()->setCreator("ctos")
    ->setLastModifiedBy("ctos")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

//set width  设置表格宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);

//设置水平居中
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// set table header content  设置表头名称
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '订单号')
    ->setCellValue('B1', '商品名称')
    ->setCellValue('C1', '商品型号')
    ->setCellValue('D1', '订单状态')
    ->setCellValue('E1', '下单日期')
    ->setCellValue('F1', '收货人姓名')
    ->setCellValue('G1', '收货人电话')
    ->setCellValue('H1', '收货地址');


$rownum=1;
//while ($rows_saleinfo=mysql_fetch_assoc($rs_saleinfo))
while($row = $rs -> fetch_assoc())
{
    $rownum++;

    $row['bill_time']=$get_time->sec_time_format($row['bill_time']);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rownum, $row['bill_code']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rownum, $row['p_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rownum, $row['spe_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rownum, $row['bill_status_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rownum, $row['bill_time']);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rownum, $row['rcv_man']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $rownum, $row['rcv_tel_number']);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $rownum, $row['rcv_province'].$row['rcv_city'].$row['rcv_county'].$row['rcv_detailInfo']);

}

mysqli_close($conn);

$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//  $filename="销售订单".date('Y-m-d');
// Redirect output to a client’s web browser (Excel5)
//  ob_end_clean();//清除缓冲区,避免乱码  
header('Content-Type: application/vnd.ms-excel');
//  header('Content-Disposition: attachment;filename='.$filename);
header('Content-Disposition: attachment;filename="奥田总订单.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
