<?php

include_once "../../../config/db_config.php";
include_once "Role.php";
class Member{
    private $memberList;
    protected static $member;

    public function __construct(){}

    //成员登录方法
    public function login($member_account,$member_password){
        $login_sql = "select * from tssq_member where member_account = '$member_account' and member_password = '$member_password'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $login_rs=$conn ->query($login_sql);
        if($login_row = $login_rs -> fetch_assoc()){
            $rid = $login_row['rid'];
            $competence_sql = "select * from tssq_role where rid = '$rid'";
            $competence_rs=$conn ->query($competence_sql);
            $competenceList_row = $competence_rs -> fetch_assoc();
            $login_row['role_competence'] = $competenceList_row['role_competence'];
            return $connect ->out_msg(1,'登陆成功！',$login_row);
//            $expire=time()+60*60*24*1;
//            $user_msg=json_encode($login_row);
//            setcookie('member_cookie',$user_msg,$expire,'/');
        }else{
            return $connect -> out_msg(0,'用户不存在或密码错误');
        }
    }
    public function selectMemberById($mid){
        $selectMember_sql = "select * from tssq_member where member_id = '$mid'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectMember_rs=$conn ->query($selectMember_sql);
        return $selectMember_row = $selectMember_rs -> fetch_assoc();
    }
    //获取角色对应成员
    public function selectMemberByRole($ridList){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();

        $i=0;//循环变量
        //--得到$teacher_arry数组长度
        $num=count($ridList);
        //--遍历数组，将对应信息添加入数据库

        $memberList = array();

        for ($i;$i<$num;$i++){
            $rid=$ridList[$i]['rid'];
            $selectMember_sql = "select * from tssq_member where rid = '$rid'";
            $memberList_rs = $conn -> query($selectMember_sql);
            while($memberList_row = $memberList_rs -> fetch_assoc()){
                $memberObj =array();
                $memberObj['mid'] = $memberList_row['mid'];
                $memberObj['member_name'] = $memberList_row['member_name'];
                array_push($memberList,$memberObj);
            }
        }

        return $connect -> out_msg(1,'查询成功',$memberList);
    }

    //根据成员角色查询
    public function getMemberList($page,$rows,$mid,$rid,$member_name,$member_tel){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($rid !=null){
            $where.= " and rid = '$rid'";
        }
        if($mid !=null){
            $where.= " and mid = '$mid'";
        }
        if($member_tel !=null){
            $where.= " and member_tel= '$member_tel'";
        }
        if($member_name !=null){
            $where.= " and member_name like '%$member_name%'";
        }
        $memberList_sql = "select * from tssq_member ".$where." limit $offset,$rows";
        $memberList_rs=$conn ->query($memberList_sql);
        $memberListCount_sql = "select count(*) from tssq_member ".$where;  //sql查询语句，根据角色姓名模糊查询
        $memberListCount_rs=$conn ->query($memberListCount_sql);
        $row=$memberListCount_rs -> fetch_row();
        $count=$row[0];
        $conn -> close();
        $memberList=array();
        while($memberList_row = $memberList_rs -> fetch_assoc()){
            array_push($memberList,$memberList_row);
        }
        return $connect -> out_msg2(1,'',$count,$this->memberList = $memberList);
    }

    //获取相应角色成员数量
    public function getMemberCount($rid){
        $selectRole_sql = "select count(*) from tssq_member where rid = '$rid'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectRole_rs=$conn ->query($selectRole_sql);
        $selectRole_row = $selectRole_rs -> fetch_row();
        $count = $selectRole_row[0];
        return $count;
    }

    //新增成员
    public function addMember($rid,$member_name,$member_tel,$member_account,$member_password){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $memberCount = $this->getMemberCount($rid);
        $role = new Role();
        $role_amount = $role->selectRoleById($rid)['role_amount'];
        if($memberCount<$role_amount){
            $insertMember_sql = "insert into tssq_member(rid,member_name,member_tel,member_account,member_password ) VALUE('$rid','$member_name','$member_tel','$member_account','$member_password')";
            $conn ->query($insertMember_sql);
            $insertMember_rs = mysqli_affected_rows($conn);
            if($insertMember_rs){
                return $connect -> out_msg(1,'新增成员成功!');
            }else{
                return $connect -> out_msg(0,'新增成员失败!');
            }
        }else{
            return $connect -> out_msg(2,'角色人数到达上限!');
        }
        $conn -> close();
    }

    public function modifyMember($mid,$rid,$member_name,$member_tel,$member_account,$member_password){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $memberCount = $this->getMemberCount($rid);
        $role = new Role();
        $role_amount = $role->selectRoleById($rid)['role_amount'];
        if($memberCount<=$role_amount){
            $updateMember_sql = "update tssq_member set rid = '$rid',member_name = '$member_name',member_tel='$member_tel', ".
                "member_account='$member_account',member_password = '$member_password'  where mid = '$mid' ";
            $conn ->query($updateMember_sql);
            $updateMember_rs=mysqli_affected_rows($conn);
            if($updateMember_rs){
                return $connect -> out_msg(1,'更新成员成功!');
            }else{
                return $connect -> out_msg(0,'更新成员失败!');
            }
        }else{
            return $connect -> out_msg(2,'角色人数到达上限!');
        }
        $conn -> close();
    }

    public function deleteMember($mid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteMember_sql = "delete from tssq_member where mid = '$mid'";
        $conn ->query($deleteMember_sql);
        $deleteMember_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteMember_rs){
            return $connect -> out_msg(1,'删除成员成功!');
        }else{
            return $connect -> out_msg(0,'删除成员失败!');
        }
    }


}



