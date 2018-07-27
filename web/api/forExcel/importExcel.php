<?php
include_once "../../../config/db_configa.php";
include_once "../../../config/file.php";
echo "aaaaa";
header("Content-type:text/html;charset=utf-8");

//if($_POST['leadExcel'] == "true")
//{
//    $filename = $_FILES['inputExcel']['name'];
//    $tmp_name = $_FILES['inputExcel']['tmp_name'];
//    $extend=strrchr ($filename,'.');
//    $extendLower = strtolower($extend);
//    /*判别是不是.xls和.xlsx文件，判别是不是excel文件*/
//    if (($extendLower != ".xls") && ($extendLower != ".xlsx"))
//    {
//        echo '不是Excel文件，请重新上传！';
//        exit;
//    }else{
//        $msg = uploadFile($filename,$tmp_name);
//echo $msg;
//    }
//}
$excel_file=$_FILES['file'];//得到传输的数据
$filename = 'aaaa';
$tmp_name = 'bbbb';
echo "aaaaa";
$extend=strrchr ($filename,'.');
$extendLower = strtolower($extend);
/*判别是不是.xls和.xlsx文件，判别是不是excel文件*/
if (($extendLower != ".xls") && ($extendLower != ".xlsx"))
{
    echo '不是Excel文件，请重新上传！';
    exit;
}else{
    $msg = uploadFile($filename,$tmp_name);
echo $msg;
}
//
//$file=new file();
//$excel_name=$file ->upload_excel_file($excel_file,"E:/projects/aotian_2018_01_23/excel/",time());
//$excel_path='E:/projects/aotian_2018_01_23/excel/'.$excel_name;
//$excel_url='https://wx.xingda188.com/aotian_2018_01_23/excel/'.$excel_name;
//
//$msg = uploadFile($excel_name,'aaaa.xls');

/***************定义导入Excel文件的方法********************************/
//导入Excel文件
function uploadFile($file,$filetempname)
{
    //自己设置的上传文件存放路径
    $filePath = './upFile/';
    $str = "";
    /** Error reporting */
    error_reporting(E_ALL);
    /** Include path **/
    set_include_path(get_include_path() . PATH_SEPARATOR . '../phpexcel/');
    /** PHPExcel */
    include '../../../phpexcel/PHPExcel.php';
    /** PHPExcel_IOFactory */
    include '../../../phpexcel/PHPExcel/IOFactory.php';
    /** PHPExcel_Reader */
    include '../../../phpexcel/PHPExcel/Reader/Excel5.php';
    include '../../../phpexcel/PHPExcel/Reader/Excel2007.php';
    //注意设置时区
    $time=date("y-m-d-H-i-s");//去当前上传的时间
    //获取上传文件的扩展名
    $extend=strrchr ($file,'.');
//根据当前时间外加后五位产生一个 防止多个用户同时操作产生的重复概率
    $randnum = $time.str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    //上传后的文件名
    $name=$randnum.$extend;
    $uploadfile=$filePath.$name;//上传后的文件名地址
    //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
    $result=move_uploaded_file($filetempname,$uploadfile);//假如上传到当前目录下
    // echo $result;
    if($result) //如果上传文件成功，就执行导入excel操作
    {
        if($extend==".xlsx"){
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2007 for 2007 format
        }else{
            $objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
        }
        $objPHPExcel = $objReader->load($uploadfile);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数

        /* 第一种方法
        //循环读取excel文件,读取一条,插入一条
        for($j=1;$j<=$highestRow;$j++)                        //从第一行开始读取数据
        {
            for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
            {
                //
                这种方法简单，但有不妥，以''合并为数组，再分割为字段值插入到数据库
                实测在excel中，如果某单元格的值包含了导入的数据会为空
                //
                $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'';//读取单元格
            }
            //echo $str; die();
            //explode:函数把字符串分割为数组。
            $strs = explode("",$str);
            $sql = "INSERT INTO te(`1`, `2`, `3`, `4`, `5`) VALUES (
            '{$strs[0]}',
            '{$strs[1]}',
            '{$strs[2]}',
            '{$strs[3]}',
            '{$strs[4]}')";
            //die($sql);
            if(!mysql_query($sql))
            {
                return false;
                echo 'sql语句有误';
            }
            $str = "";
        }
        unlink($uploadfile); //删除上传的excel文件
        $msg = "导入成功！";
        */
        /* 第二种方法*/
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        // echo 'highestRow='.$highestRow;
        // echo "<br>";
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
        // echo 'highestColumnIndex='.$highestColumnIndex;
        // echo "<br>";
        $headtitle=array();
        // for ($row = 1;$row <= $highestRow;$row++) //从第一行开始读取数据
        for ($row = 2;$row <= $highestRow;$row++) //从第二行开始读取数据，一般第一行作为名称
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                if($col=='6'){//指定g列为时间所在列 第七列
                    $strs[$col] = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()));
                }else{
                    $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }

            }
            $mylist[$row]['name'] = $strs[0];
            $mylist[$row]['spec'] = $strs[1];
            $mylist[$row]['unit'] = $strs[2];
            $mylist[$row]['nums'] = $strs[3];
            $mylist[$row]['brand'] = $strs[4];
            $mylist[$row]['note'] = $strs[5];
            $mylist[$row]['totime'] = $strs[6];
            $mylist[$row]['catid'] = $strs[7];
            $mylist[$row]['catname'] = $strs[8];
        }
        $msg = $mylist;
        echo '$msg';
        echo json_encode($msg);
    }
    else
    {
        $msg = "导入失败！";
    }
    return $msg;
}
