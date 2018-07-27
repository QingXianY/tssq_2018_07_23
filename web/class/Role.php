<?php
include_once "../../../config/db_config.php";
include_once "Competence.php";
class Role{
    private $roleList;

    public function __construct(){}


    //检查添加时名字重复
    public function selectRoleByName($role_name){
        $selectRole_sql = "select * from tssq_role where role_name = '$role_name'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectRole_rs=$conn ->query($selectRole_sql);
        return $selectRole_row = $selectRole_rs -> fetch_assoc();
    }

    //检查修改时重复
    public function selectRoleById($rid){
        $selectRole_sql = "select * from tssq_role where rid = '$rid'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectRole_rs=$conn ->query($selectRole_sql);
        return $selectRole_row = $selectRole_rs -> fetch_assoc();
    }


    //获取角色列表
    public function getRoleList($page,$rows,$role_name){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($role_name){
            $where.= " and role_name like '%$role_name%'";
        }
        $roleList_sql = "select * from tssq_role ".$where." limit $offset,$rows";  //sql查询语句，根据角色姓名模糊查询
        $roleList_rs=$conn ->query($roleList_sql);
        $roleList=array();
        $roleListCount_sql = "select count(*) from tssq_role ".$where;  //sql查询语句，根据角色姓名模糊查询
        $roleListCount_rs=$conn ->query($roleListCount_sql);
        $row=$roleListCount_rs -> fetch_row();
        $count=$row[0];
        while($roleList_row = $roleList_rs -> fetch_assoc()){
//            $rid = $roleList_row['rid'];
//            $competence_sql = "select * from v_role_competence where rid = '$rid'";
//            $competence_rs=$conn ->query($competence_sql);
//            $competenceNameList=array();
//            $competenceIdList=array();
//            while ($competenceList_row = $competence_rs -> fetch_assoc()){
//                array_push($competenceNameList,$competenceList_row['competence_name']);  //权限名称，由于要写死，所以只返回id
//                array_push($competenceIdList,$competenceList_row['cid']);
//            }
//            $roleList_row['role_competence'] = $competenceNameList;
//            $roleList_row['role_competence_id'] = $competenceIdList;
            array_push($roleList,$roleList_row);
        }
        $conn -> close();
        return $connect -> out_msg2(1,'',$count,$this->roleList = $roleList);
    }

    //根据权限获取角色
    public function getRoleByCompetence($cid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $competence = new Competence();
        $competence_row = $competence->getCompetenceById($cid);
        $roleList_sql = "select * from tssq_role where role_competence like '%\"competence_name\":\"".$competence_row['competence_name']."\",\"flag\":\"true\"%' ";
        $roleList_rs=$conn ->query($roleList_sql);
        $roleList=array();
        while($roleList_row = $roleList_rs -> fetch_assoc()){

            array_push($roleList,$roleList_row);

        }
        return $roleList;
    }

    //根据获取角色id获取权限列表
    public function getRoleCompetenceListById($rid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $roleCompetenceList_sql = "select * from tssq_role where rid = '$rid'";
        $roleCompetenceList_rs=$conn ->query($roleCompetenceList_sql);
        $roleCompetenceList = array();
        while ($roleCompetenceList_row = $roleCompetenceList_rs -> fetch_assoc()){
            array_push($roleCompetenceList,$roleCompetenceList_row);
        }
        $conn -> close();
        return $connect -> out_msg(1,'',$roleCompetenceList);
    }

    //新增角色,参数包含权限id数组
    public function addRole($role_name,$role_amount,$role_competence){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectRoleByName($role_name)){
            return $connect -> out_msg(2,'角色已存在!');
        }else{
            $insertRole_sql = "insert into tssq_role(role_name,role_amount,role_competence) VALUE('$role_name','$role_amount','$role_competence')";
            $conn ->query($insertRole_sql);
            $insertRole_rs=mysqli_affected_rows($conn);
            if($insertRole_rs){
                return $connect -> out_msg(1,'新增角色成功!');
            }else{
                return $connect -> out_msg(0,'新增角色失败!');
            }
        }
    }

    public function modifyRole($rid,$role_name,$role_amount,$role_competence){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectRoleByName($role_name)&&$this->selectRoleById($rid)['role_name']!=$role_name){
            return $connect -> out_msg(2,'角色已存在!');
        }else{
            $updateRole_sql = "update tssq_role set role_name = '$role_name',role_amount='$role_amount',role_competence = '$role_competence' where rid = '$rid' ";
            $conn ->query($updateRole_sql);
            $updateRole_rs = mysqli_affected_rows($conn);
            if($updateRole_rs){
//                $deleteCompetence_sql = "delete from tssq_role_competence WHERE rid = '$rid'";
//                $conn -> query($deleteCompetence_sql);
//                // 关闭自动提交
//                mysqli_autocommit($conn,FALSE);
//                $i=0;//循环变量
//                //--得到$competence_arry数组长度
//                $num=count($competence_arry);
//
//                //--遍历数组，将对应信息添加入数据库
//                for ($i;$i<$num;$i++){
//                    $cid=$competence_arry[$i];
//                    $insertCompetence_sql = "insert into tssq_role_competence(rid,cid) VALUE('$rid','$cid')";
//                    $conn -> query($insertCompetence_sql);
//                }
//                // 提交事务
//                mysqli_commit($conn);
//                $conn -> close();
                return $connect -> out_msg(1,'更新角色成功!');
            }else{
                return $connect -> out_msg(0,'更新角色失败!');
            }
        }
    }
    public function deleteRole($rid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteAllMember_sql = "delete from xd_member where rid = '$rid'";  //角色删除前，删除所有角色对应成员
        $deleteAllMember_rs=$conn ->query($deleteAllMember_sql);
        if($deleteAllMember_rs){
            $deleteRole_sql = "delete from tssq_role where rid = '$rid'";
            $conn ->query($deleteRole_sql);
            $deleteRole_rs = mysqli_affected_rows($conn);
            $conn -> close();
            if($deleteRole_rs){
                return $connect -> out_msg(1,'删除角色成功!');
            }else{
                return $connect -> out_msg(0,'删除角色失败!');
            }
        }
    }

}




