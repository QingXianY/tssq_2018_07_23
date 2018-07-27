<?php  
include_once "../../../config/db_config.php";


class Service
{
	
	public function __construct(){}
	//个人可申请服务列表
	public function getApplyserviceList($user_id,$service_name,$page,$rows){
		$offset = ($page-1)*$rows;
		$where=" and user_id='$user_id' and service_name like '%$service_name%'";
		$sql = "select * from v_user_service where service_count>0 ".$where." limit $offset,$rows";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $rs=$conn ->query($sql);
        $sqlcount="select count(*) from v_user_service where 1=1 ".$where;
        $rscount= $conn ->query($sqlcount);
        $applyserviceList=array();
        $row=$rscount->fetch_row();
        $count=$row[0];
        while($rs_row = $rs -> fetch_assoc()){
            array_push($applyserviceList,$rs_row);
        }
        $conn->close();
        return $connect -> out_msg2(1,'',$count,$applyserviceList);
	}
	//提交申请
	public function submitApplication($user_id,$service_id){
		$sql="insert into tssq_sorder(user_id,volunteer_id,service_id,order_status) values ('$user_id','','$service_id','0')";
		$connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($sql);
        $rs=mysqli_affected_rows($conn);
        if ($rs) {
        	 $sql="update tssq_user_service set service_count=service_count-1 where user_id='$user_id' and service_id='$service_id'";
        	 $conn ->query($sql);
        	 $rs=mysqli_affected_rows($conn);
        	 $conn->close();
        	 if ($rs) {
        	 	return $connect -> out_msg(1,'申请成功!');
        	 }else{
        	 	return $connect -> out_msg(0,'申请失败!');
        	 }
        }else{
        	return $connect -> out_msg(0,'申请失败!');
        }
        
	}


	public function getDoserviceList($user_id,$service_name,$status,$volunteer_id,$page,$rows){
		$offset = ($page-1)*$rows;
		$where=" and user_id='$user_id' and service_name like '%$service_name%'";
		if (!empty($volunteer_id)) {
			$where.=" and volunteer_id='$volunteer_id'";
		}
		$sql = "select * from v_user_order where order_status='$status' ".$where." limit $offset,$rows";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $rs=$conn ->query($sql);
        $sqlcount="select count(*) from v_user_order where order_status='$status' ".$where;
        $rscount= $conn ->query($sqlcount);
        $doserviceList=array();
        $row=$rscount->fetch_row();
        $count=$row[0];
        while($rs_row = $rs -> fetch_assoc()){
            array_push($doserviceList,$rs_row);
        }
        $conn->close();
        return $connect -> out_msg2(1,'',$count,$doserviceList);
	}


	public function getServiceList($service_name,$page,$rows){
		$offset = ($page-1)*$rows;
		$where = "where 1=1 ";
		if(!empty($service_name)){
			$where.= " and service_name = '$service_name'";
		}
		$sql = "select * from tssq_service ".$where." limit $offset,$rows";
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$rs=$conn ->query($sql);
		$sqlcount="select count(*) from tssq_service ".$where;
		$rscount= $conn ->query($sqlcount);
		$serviceList=array();
		$row=$rscount->fetch_row();
		$count=$row[0];
		while($rs_row = $rs -> fetch_assoc()){
			array_push($serviceList,$rs_row);
		}
		$conn->close();
		return $connect -> out_msg2(1,'',$count,$serviceList);
	}

	public function addService($service_name,$service_content,$service_integral){
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$insertService_sql = "insert into tssq_service(service_name,service_content,service_integral) VALUE('$service_name','$service_content','$service_integral')";
		$conn ->query($insertService_sql);
		$insertService_rs = mysqli_affected_rows($conn);
		if($insertService_rs){
			return $connect -> out_msg(1,'新增服务成功!');
		}else{
			return $connect -> out_msg(0,'新增服务失败!');
		}
		$conn -> close();
	}

	public function modifyService($service_id,$service_name,$service_content,$service_integral){
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$updateService_sql = "update tssq_service set service_name = '$service_name',service_content = '$service_content',service_integral = '$service_integral' ".
			" where service_id = '$service_id' ";
		$conn ->query($updateService_sql);
		$updateService_rs=mysqli_affected_rows($conn);
		if($updateService_rs){
			return $connect -> out_msg(1,'更新服务成功!');
		}else{
			return $connect -> out_msg(0,'更新服务失败!');
		}

		$conn -> close();
	}

	public function deleteService($service_id){
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$deleteService_sql = "delete from tssq_service where service_id = '$service_id'";
		$conn ->query($deleteService_sql);
		$deleteService_rs=mysqli_affected_rows($conn);
		$conn -> close();
		if($deleteService_rs){
			return $connect -> out_msg(1,'删除服务成功!');
		}else{
			return $connect -> out_msg(0,'删除服务失败!');
		}
	}


	public function getServiceOrderList($order_code,$user_name,$volunteer_name,$service_id,$start_time,$end_time,$order_status,$page,$rows){
		$offset = ($page-1)*$rows;
		$where = "where 1=1 ";
		if(!empty($order_code)){
			$where.= " and order_code = '$order_code'";
		}
		if(!empty($user_name)){
			$where.= " and user_name like '%$user_name%'";
		}
		if(!empty($volunteer_name)){
			$where.= " and volunteer_name like '%$volunteer_name%'";
		}
		if(!empty($service_id)){
			$where.= " and service_id = '$service_id'";
		}
		if(!empty($start_time)){
			$where.= " and order_time >= '$start_time'";
		}
		if(!empty($end_time)){
			$where.= " and order_time <= '$end_time'";
		}
		if(!empty($order_status)){
			$where.= " and order_status = '$order_status'";
		}
		$sql = "select * from v_user_order ".$where." limit $offset,$rows";
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$rs=$conn ->query($sql);
		$sqlcount="select count(*) from v_user_order ".$where;
		$rscount= $conn ->query($sqlcount);
		$orderList=array();
		$row=$rscount->fetch_row();
		$count=$row[0];
		while($rs_row = $rs -> fetch_assoc()){
			array_push($orderList,$rs_row);
		}
		$conn->close();
		return $connect -> out_msg2(1,'',$count,$orderList);
	}


	public function addServiceOrder($user_id,$volunteer_id,$service_id){
		$sql="insert into tssq_sorder(user_id,volunteer_id,service_id,order_status) values ('$user_id','$volunteer_id','$service_id','0')";
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$conn ->query($sql);
		$rs=mysqli_affected_rows($conn);
		if ($rs) {
			$sql="update tssq_user_service set service_count=service_count-1 where user_id='$user_id' and service_id='$service_id'";
			$conn ->query($sql);
			$rs=mysqli_affected_rows($conn);
			$conn->close();
			if ($rs) {
				return $connect -> out_msg(1,'添加成功!');
			}else{
				return $connect -> out_msg(0,'添加失败!');
			}
		}else{
			return $connect -> out_msg(0,'添加失败!');
		}

	}

	public function modifyServiceOrder($order_code,$volunteer_id,$service_id){
		$sql = "update tssq_sorder set volunteer_id = '$volunteer_id',service_id = '$service_id' where order_code = '$order_code' ";
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$conn ->query($sql);
		$rs=mysqli_affected_rows($conn);
		if($rs){
			return $connect -> out_msg(1,'更新成功!');
		}else{
			return $connect -> out_msg(0,'更新失败!');
		}
		$conn->close();
	}

	public function deleteServiceOrder($order_code,$order_status){
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		if($order_status == 2){
			$sql = "delete from tssq_sorder where  order_code = '$order_code' ";
			$conn ->query($sql);
			$rs=mysqli_affected_rows($conn);
			if($rs){
				return $connect -> out_msg(1,'删除成功!');
			}else{
				return $connect -> out_msg(0,'删除失败!');
			}
			$conn->close();
		}else{
			return $connect -> out_msg(0,',订单未完成，删除失败!');
		}

	}

}

