<?php

include_once "../../../config/db_config.php";
include_once "../../../config/get_time.php";
include_once "Detail.php";
include_once "setting.php";

class User{

    public function __construct(){}

    //学员小程序端登陆方法
    public function login($user_tel,$user_password){
        $type=0;
        $login_sql = "select * from tssq_user where user_tel = '$user_tel' and user_password = '$user_password'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $login_rs=$conn ->query($login_sql);

        if($login_rs->num_rows<=0){
            $type=1;
            $login_sql = "select * from tssq_volunteer where volunteer_tel = '$user_tel' and volunteer_password = '$user_password'";
            $login_rs=$conn ->query($login_sql);
         }

        if($login_row = $login_rs -> fetch_assoc()){
            if ($type==0) {
                $this->updateLogin($login_row['user_id']);   
            }else{
                $this->updateLogin2($login_row['volunteer_id']);
            }   
            return $connect ->out_msg(1,'登陆成功！',$login_row);
        }else{
            return $connect -> out_msg(0,'用户不存在或密码错误');
        }
    }
     //更新学员小程序最后登陆时间
    public function updateLogin($user_id){
        $get_time = new get_time();
        $last_login = $get_time->get_now_sec();
        $updateLogin_sql = "update tssq_user set last_login_time = '$last_login' where user_id = '$user_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($updateLogin_sql);
    }
    public function updateLogin2($volunteer_id){
        $get_time = new get_time();
        $last_login = $get_time->get_now_sec();
        $updateLogin_sql = "update tssq_volunteer set last_login_time = '$last_login' where volunteer_id = '$volunteer_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($updateLogin_sql);
    }
    //检查重复注册
    public function selectUserByTel($user_tel){
        $selectUser_sql = "select * from tssq_user where user_tel = '$user_tel'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectUser_rs=$conn ->query($selectUser_sql);
        return $selectUser_rs -> fetch_assoc();
    }
    public function selectVolunteerByTel($volunteer_tel){
        $selectsql = "select * from tssq_volunteer where volunteer_tel='$volunteer_tel'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectrs=$conn ->query($selectsql);
        return $selectrs -> fetch_assoc();
    }

    //群众注册
    public function register_user($user_name,$user_tel,$user_pic,$user_cardid,$user_location,$user_password){
        $connect= db_config::getInstance();
        $register_sql = "insert into tssq_user(user_name,user_tel,user_pic,user_password,user_cardid,user_location,register_time,last_login_time,ts)values('$user_name','$user_tel','$user_pic','$user_password','$user_cardid','$user_location',null,null,null)";
        $conn=$connect->connect_bdb();
        $conn ->query($register_sql);
        $register_rs = mysqli_affected_rows($conn);
        $conn->close();
        if($register_rs){
            return $connect -> out_msg(1,'验证通过，注册成功!');;
        }else{
            return $connect -> out_msg(0,'注册失败!');
        }
    }
    //志愿者注册
    public function register_volunteer($flag,$volunteer_name,$volunteer_tel,$volunteer_pic,$volunteer_password,$volunteer_pro,$volunteer_motto){
        $connect= db_config::getInstance();
        $register_sql = "insert into tssq_volunteer(volunteer_name,volunteer_tel,volunteer_pic,volunteer_password,volunteer_pro,volunteer_motto,volunteer_assessment,volunteer_integral,flag) values ('$volunteer_name', '$volunteer_tel', '$volunteer_pic', '$volunteer_password', '$volunteer_pro', '$volunteer_motto', '', '0', '$flag');";
        $conn=$connect->connect_bdb();
        $conn ->query($register_sql);
        $register_rs = mysqli_affected_rows($conn);
        if($register_rs){
            return $connect -> out_msg(1,'验证通过，注册成功!');;
        }else{
            return $connect -> out_msg(0,'注册失败!');
        }

    }

    //修改志愿者
    public function updateVolunteer($volunteer_id,$volunteer_name,$volunteer_tel,$volunteer_pic,$volunteer_password,$volunteer_pro,$volunteer_motto,$volunteer_assessment,$volunteer_integral){
        $set="set ";
        if (!empty($volunteer_name)) {
            $set.="volunteer_name='$volunteer_name', ";
        }
        if (!empty($volunteer_tel)) {
            $set.="volunteer_tel='$volunteer_tel', ";
        }
        if (!empty($volunteer_pic)) {
            $set.="volunteer_pic='$volunteer_pic', ";
        }
        if (!empty($volunteer_password)) {
            $set.="volunteer_password='$volunteer_password', ";
        }
        if (!empty($volunteer_motto)) {
            $set.="volunteer_motto='$volunteer_motto', ";
        }
        if (!empty($volunteer_assessment)) {
            $set.="volunteer_assessment='$volunteer_assessment', ";
        }
        if (!empty($volunteer_integral)) {
            $set.="volunteer_integral='$volunteer_integral', ";
        }
        $set.="volunteer_id='$volunteer_id'";
        $sql="update tssq_volunteer ".$set."  where volunteer_id='$volunteer_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($sql);
        $update_rs = mysqli_affected_rows($conn);
        $conn->close();
        if($update_rs){
            return $connect -> out_msg(1,'操作成功');;
        }else{
            return $connect -> out_msg(0,'操作失败');
        }
    }
    //修改群众
    public function updateUser($user_id,$user_name,$user_tel,$user_pic,$user_password,$user_cardid,$user_location){
        $set="set ";
        if (!empty($user_name)) {
            $set.="user_name='$user_name', ";
        }
        if (!empty($user_tel)) {
            $set.="user_tel='$user_tel', ";
        }
        if (!empty($user_pic)) {
            $set.="user_pic='$user_pic', ";
        }
        if (!empty($user_password)) {
            $set.="user_password='$user_password', ";
        }
        if (!empty($user_cardid)) {
            $set.="user_cardid='$user_cardid', ";
        }
        if (!empty($user_location)) {
            $set.="user_location='$user_location', ";
        }
        $set.="user_id='$user_id'";
        $sql="update tssq_user ".$set."  where user_id='$user_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($sql);
        $update_rs = mysqli_affected_rows($conn);
        $conn->close();
        if($update_rs){
            return $connect -> out_msg(1,'操作成功');;
        }else{
            return $connect -> out_msg(0,'操作失败');
        }
    }

    //获取标签
    public function getTag(){
        $sql = "select * from tssq_tag";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $rs=$conn ->query($sql);
        $tagList=array();
        while($rs_row = $rs -> fetch_assoc()){
            array_push($tagList,$rs_row);
        }
        $conn->close();
        return $connect -> out_msg(1,'',$tagList);
    }
    //操作用户积分
    public function modifyIntegral($volunteer_id,$modify_type,$modify_remark,$modify_value){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $get_time = new get_time();
        $present = $get_time->get_now_sec();
        $volunteer_integral = $this->selectById($volunteer_id)['volunteer_integral'];
        $volunteer_integral_new= $modify_type==0?$volunteer_integral-$modify_value:$volunteer_integral+$modify_value;
        $updateStudent_sql = "update tssq_volunteer set volunteer_integral = '$volunteer_integral_new' where volunteer_id = '$volunteer_id' ";
        $conn ->query($updateStudent_sql);
        $updateStudent_rs=mysqli_affected_rows($conn);
        if($updateStudent_rs){
            $Detail=new Detail();
            $Detail->addDetail($volunteer_id,$modify_remark,$modify_type,$modify_value,$present);
            $conn -> close();
            return $connect -> out_msg(1,'操作积分成功!');
        }else{
            return $connect -> out_msg(0,'操作积分失败!');
        }
    }
    //根据id查询用户
    public function selectById($volunteer_id){
        $selectStudent_sql = "select * from tssq_volunteer where volunteer_id = '$volunteer_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectStudent_rs=$conn ->query($selectStudent_sql);
        return $selectStudent_row = $selectStudent_rs -> fetch_assoc();
    }
    //根据id查询用户
    public function selectById1($volunteer_id){
        $selectStudent_sql = "select * from tssq_volunteer where volunteer_id = '$volunteer_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectStudent_rs=$conn ->query($selectStudent_sql);
        return $connect -> out_msg(1,'',$selectStudent_rs -> fetch_assoc());
    }


    //获取群众列表
    public function getUserList($page,$rows,$user_name,$user_tel){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";

        if($user_name != null ){
            $where.= " and user_name like '%$user_name%'";
        }
        if($user_tel != null){
            $where.= " and user_tel = '$user_tel'";
        }
        $userList_sql = "select * from tssq_user ".$where." limit $offset,$rows";  //sql查询语句，根据学生姓名模糊查询
        $userList_rs=$conn ->query($userList_sql);
        $userList=array();
        $userListCount_sql = "select count(*) from tssq_user ".$where;  //sql查询语句，根据角色姓名模糊查询
        $userListCount_rs=$conn ->query($userListCount_sql);
        $row=$userListCount_rs -> fetch_row();
        $count=$row[0];
        while($userList_row = $userList_rs -> fetch_assoc()){
            array_push($userList,$userList_row);
        }
        return $connect -> out_msg2(1,'',$count,$userList);
    }

	//获取志愿者列表
	public function getVolunteerList($page,$rows,$volunteer_name,$volunteer_tel){
		$offset = ($page-1)*$rows;
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$where = "where 1=1";

		if($volunteer_name != null ){
			$where.= " and volunteer_name like '%$volunteer_name%'";
		}
		if($volunteer_tel != null){
			$where.= " and volunteer_tel = '$volunteer_tel'";
		}
		$volunteerList_sql = "select * from tssq_volunteer ".$where." limit $offset,$rows";  //sql查询语句，根据学生姓名模糊查询
		$volunteerList_rs=$conn ->query($volunteerList_sql);
		$volunteerList=array();
		$volunteerListCount_sql = "select count(*) from tssq_volunteer ".$where;  //sql查询语句，根据角色姓名模糊查询
		$volunteerListCount_rs=$conn ->query($volunteerListCount_sql);
		$row=$volunteerListCount_rs -> fetch_row();
		$count=$row[0];
		while($volunteerList_row = $volunteerList_rs -> fetch_assoc()){
			array_push($volunteerList,$volunteerList_row);
		}
		return $connect -> out_msg2(1,'',$count,$volunteerList);
	}



    public function deleteUser($user_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteUser_sql = "delete from tssq_user where user_id = '$user_id'";
        $conn ->query($deleteUser_sql);
        $deleteUser_rs=mysqli_affected_rows($conn);
        if($deleteUser_rs){
            $deleteUserService_sql = "delete from tssq_user_service where user_id = '$user_id'";
            $conn ->query($deleteUserService_sql);
			$deleteUserOrder_sql = "delete from tssq_sorder where user_id = '$user_id'";
			$conn ->query($deleteUserOrder_sql);
            return $connect -> out_msg(1,'删除成功!');
        }else{
            return $connect -> out_msg(0,'删除失败!');
        }
        $conn -> close();
    }

	public function deleteVolunteer($volunteer_id){
		$connect= db_config::getInstance();
		$conn=$connect->connect_bdb();
		$deleteVolunteer_sql = "delete from tssq_volunteer where volunteer_id = '$volunteer_id'";
		$conn ->query($deleteVolunteer_sql);
		$deleteVolunteer_rs=mysqli_affected_rows($conn);
		if($deleteVolunteer_rs){
			$deleteVolunteerDetail_sql = "delete from tssq_detail where volunteer_id = '$volunteer_id'";
			$conn ->query($deleteVolunteerDetail_sql);
			$deleteVolunteerOrder_sql = "delete from tssq_porder where volunteer_id = '$volunteer_id'";
			$conn ->query($deleteVolunteerOrder_sql);
			return $connect -> out_msg(1,'删除学生成功!');
		}else{
			return $connect -> out_msg(0,'删除学生失败!');
		}
		$conn -> close();
	}
}



