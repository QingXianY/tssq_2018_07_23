<?php
include_once "../../../config/db_config.php";
include_once "../../../config/get_time.php";
class Detail{
    private $detailList;

    public function __construct(){}

    //获取用户积分明细列表
    public function getDetailList($page,$rows,$volunteer_id,$detail_type,$start_date,$end_date){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where volunteer_id = '$volunteer_id' ";
        if($detail_type!=''){
            $where.= " and detail_type = '$detail_type' ";
        }
        if($start_date){
            $where.= " and detail_date >= '$start_date' ";
        }
        if($end_date){
            $where.= " and detail_date <= '$end_date' ";
        }
        $detailList_sql = "select * from v_volunteer_detail ".$where." order by detail_date desc"." limit $offset,$rows";  //sql查询语句，根据日期查询
        $detailList_rs=$conn ->query($detailList_sql);
        $detailList=array();
        $detailListCount_sql = "select count(*) from v_volunteer_detail ".$where;  //sql查询语句，根据角色姓名模糊查询
        $detailListCount_rs=$conn ->query($detailListCount_sql);
        $row=$detailListCount_rs -> fetch_row();
        $count=$row[0];
        $conn->close();
        $get_time = new get_time();
        while($detailList_row = $detailList_rs -> fetch_assoc()){
            $detail_format_date = $get_time->sec_time_format_d($detailList_row['detail_date']);
            $detailList_row['detail_format_date'] = $detail_format_date;
            array_push($detailList,$detailList_row);
        }
        return $connect -> out_msg2(1,"",$count,$this->detailList = $detailList);
    }

    //新增明细
    public function addDetail($volunteer_id,$detail_content,$detail_type,$detail_value,$detail_date){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $insertDetail_sql = "insert into tssq_detail(volunteer_id,detail_content,detail_type,detail_value,detail_date) VALUE('$volunteer_id','$detail_content','$detail_type','$detail_value','$detail_date')";
        $conn ->query($insertDetail_sql);
        $insertDetail_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($insertDetail_rs){
            return $connect -> out_msg(1,'新增明细成功!');
        }else{
            return $connect -> out_msg(0,'新增明细失败!');
        }
    }

    //删除明细
    public function deleteDetail($rid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteDetail_sql = "delete from tssq_detail where rid = '$rid'";
        $conn ->query($deleteDetail_sql);
        $deleteDetail_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteDetail_rs){
            return $connect -> out_msg(1,'删除明细成功!');
        }else{
            return $connect -> out_msg(0,'删除明细失败!');
        }
    }
}



