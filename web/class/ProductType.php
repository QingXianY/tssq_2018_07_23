<?php

include_once "../../../config/db_config.php";
class ProductType{
    private $productTypeList;

    public function __construct(){}

    //检查添加商品分类重复
    public function selectProductTypeByName($productType_name){
        $selectProductType_sql = "select * from tssq_ptype where type_name = '$productType_name'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectProductType_rs=$conn ->query($selectProductType_sql);
        return $selectProductType_row = $selectProductType_rs -> fetch_assoc();
    }

    //检查修改商品分类重复
    public function selectProductTypeById($type_id){
        $selectProductType_sql = "select * from tssq_ptype where type_id = '$type_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectProductType_rs=$conn ->query($selectProductType_sql);
        return $selectProductType_row = $selectProductType_rs -> fetch_assoc();
    }

    //获取商品类型列表
    public function getProductTypeList($page,$rows,$productType_name){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($productType_name){
            $where.= " and type_name like '%$productType_name%'";
        }
        $productTypeList_sql = "select * from tssq_ptype ".$where." limit $offset,$rows";  //sql查询语句，根据商品类型姓名模糊查询

        $productTypeList_rs=$conn ->query($productTypeList_sql);
        $productTypeList=array();
        $productTypeListCount_sql = "select count(*) from tssq_ptype ".$where;  //sql查询语句，根据角色姓名模糊查询
        $productTypeListCount_rs=$conn ->query($productTypeListCount_sql);
        $row=$productTypeListCount_rs -> fetch_row();
        $count=$row[0];
        while($productTypeList_row = $productTypeList_rs -> fetch_assoc()){

            array_push($productTypeList,$productTypeList_row);

        }
        return $connect -> out_msg2(1,'',$count,$this->productTypeList = $productTypeList);
    }

    //新增产品类型
    public function addProductType($productType_name,$productType_remark){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectProductTypeByName($productType_name)){
            return $connect -> out_msg(2,'产品类型已存在!');
        }else{
            $insertProductType_sql = "insert into tssq_ptype(type_name,type_remark) VALUE('$productType_name','$productType_remark')";
            $conn ->query($insertProductType_sql);
            $insertProductType_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($insertProductType_rs){
                return $connect -> out_msg(1,'新增商品类型成功!');
            }else{
                return $connect -> out_msg(0,'新增商品类型失败!');
            }
        }
    }
    public function modifyProductType($type_id,$productType_name,$productType_remark){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        //修改商品名称时，不能改为除自身外已有商品名称
        if($this->selectProductTypeByName($productType_name)&&$this->selectProductTypeById($type_id)['type_name'] != $productType_name){
            return $connect -> out_msg(2,'产品类型已存在!');

        }else{
            $updateProductType_sql = "update tssq_ptype set type_name = '$productType_name',type_remark='$productType_remark' where type_id = '$type_id' ";
            $conn ->query($updateProductType_sql);
            $updateProductType_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($updateProductType_rs){
                return $connect -> out_msg(1,'更新商品类型成功!');
            }else{
                return $connect -> out_msg(0,'更新商品类型失败!');
            }
        }
    }
    public function deleteProductType($type_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteAllProduct_sql = "delete from xd_product where type_id = '$type_id'";
        $deleteAllProduct_rs=$conn ->query($deleteAllProduct_sql);
        if($deleteAllProduct_rs){
            $deleteProductType_sql = "delete from tssq_ptype where type_id = '$type_id'";
            $conn ->query($deleteProductType_sql);
            $deleteProductType_rs=mysqli_affected_rows($conn);
            if($deleteProductType_rs){
                return $connect -> out_msg(1,'删除商品类型成功!');
            }else{
                return $connect -> out_msg(0,'删除商品类型失败!');
            }
        }
        $conn -> close();
    }

}



