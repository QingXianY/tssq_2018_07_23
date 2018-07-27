<?php

include_once "../../../config/db_config.php";
class Competence{
    private $competenceList;

    public function __construct(){}

    //获取权限列表
    public function getCompetenceList(){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $competenceList_sql = "select * from tssq_competence";  //sql查询语句，根据权限姓名模糊查询
        $competenceList_rs=$conn ->query($competenceList_sql);
        $competenceList=array();
        while($competenceList_row = $competenceList_rs -> fetch_assoc()){

            $comptenceObj = array();
            $comptenceObj['competence_id'] =$competenceList_row['cid'];
            $comptenceObj['competence_name'] =$competenceList_row['competence_name'];
            $comptenceObj['flag'] ='false';
            array_push($competenceList,$comptenceObj);

        }
        return $connect -> out_msg(1,'',$competenceList);
    }

    //获取id获取权限
    public function getCompetenceById($cid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $competenceList_sql = "select * from tssq_competence where cid = '$cid'";  //sql查询语句，根据权限姓名模糊查询
        $competenceList_rs=$conn ->query($competenceList_sql);
        $competenceList_row = $competenceList_rs -> fetch_assoc();

        return $competenceList_row;
    }



}



