<?php

include_once "../../../config/db_config.php";
include_once "../../../config/file.php";
class Product{
    private $productList;
    protected static $product;

    public function __construct(){}

    public function selectProductById($product_id){
        $selectProduct_sql = "select * from tssq_product where product_id = '$product_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectProduct_rs=$conn ->query($selectProduct_sql);
        return $selectProduct_row = $selectProduct_rs -> fetch_assoc();
    }

    //根据商品类别查询上架商品，并按销量排序
    public function getProductList($page,$rows,$type_id,$product_id,$product_name){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where product_status = 1 ";
        if($type_id){
            $where.= " and type_id = '$type_id'";
        }elseif($product_id){
            $where.= " and product_id = '$product_id'";
        }elseif($product_name){
            $where.= " and product_name like '%$product_name%'";
        }
        $productList_sql = "select * from tssq_product ".$where." order by product_sale desc"." limit $offset,$rows";
        $productList_rs=$conn ->query($productList_sql);
        $productListCount_sql = "select count(*) from tssq_product ".$where;  //sql查询语句，根据角色姓名模糊查询
        $productListCount_rs=$conn ->query($productListCount_sql);
        $row=$productListCount_rs -> fetch_row();
        $count=$row[0];
        $conn -> close();
        $productList=array();
        while($productList_row = $productList_rs -> fetch_assoc()){
            array_push($productList,$productList_row);
        }
        return $connect -> out_msg2(1,'',$count,$this->productList = $productList);
    }
    //根据商品类别查询所有商品，并按添加顺序倒叙
    public function getProductList2($page,$rows,$type_id,$product_id,$product_name){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1 = 1 ";
        if($type_id){
            $where.= " and type_id = '$type_id'";
        }elseif($product_id){
            $where.= " and product_id = '$product_id'";
        }elseif($product_name){
            $where.= " and product_name like '%$product_name%'";
        }
        $productList_sql = "select * from tssq_product ".$where." order by product_id desc"." limit $offset,$rows";
        $productList_rs=$conn ->query($productList_sql);
        $productListCount_sql = "select count(*) from tssq_product ".$where;  //sql查询语句，根据角色姓名模糊查询
        $productListCount_rs=$conn ->query($productListCount_sql);
        $row=$productListCount_rs -> fetch_row();
        $count=$row[0];
        $conn -> close();
        $productList=array();
        while($productList_row = $productList_rs -> fetch_assoc()){
            array_push($productList,$productList_row);
        }
        return $connect -> out_msg2(1,'',$count,$this->productList = $productList);
    }
    //新增商品
    public function addProduct($type_id,$product_name,$product_pic,$product_price,$product_description,$product_storage,$product_content){

        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $insertProduct_sql = "insert into tssq_product(type_id,product_name,product_pic,product_price,product_description,".
        "product_sale,product_storage,product_content,product_status) VALUE('$type_id','$product_name','$product_pic','$product_price','$product_description',0,'$product_storage','$product_content',0)";
        $conn ->query($insertProduct_sql);
        $insertProduct_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($insertProduct_rs){
            return $connect -> out_msg(1,'新增商品成功!');
        }else{
            return $connect -> out_msg(0,'新增商品失败!');
        }
    }
    public function modifyProduct($product_id,$type_id,$product_name,$product_pic,$product_price,$product_description,$product_sale,$product_storage,$product_content){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $updateProduct_sql = "update tssq_product set type_id = '$type_id',product_name = '$product_name',product_pic='$product_pic',".
        "product_price='$product_price',product_description = '$product_description',product_sale = '$product_sale',product_storage = '$product_storage',product_content = '$product_content' where product_id = '$product_id' ";
        $conn ->query($updateProduct_sql);
        $updateProduct_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateProduct_rs){
            return $connect -> out_msg(1,'更新商品成功!');
        }else{
            return $connect -> out_msg(0,'更新商品失败!');
        }
    }
    //商品上下架
    public function upDownProduct($product_id,$product_status){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();

        $updateProduct_sql = "update tssq_product set product_status = '$product_status' where product_id = '$product_id' ";
        $conn ->query($updateProduct_sql);
        $updateProduct_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateProduct_rs){
            return $connect -> out_msg(1,'操作商品成功!');
        }else{
            return $connect -> out_msg(0,'操作商品失败!');
        }
    }

    public function deleteProduct($product_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteProduct_sql = "delete from tssq_product where product_id = '$product_id'";
        $conn ->query($deleteProduct_sql);
        $deleteProduct_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteProduct_rs){
            return $connect -> out_msg(1,'删除商品成功!');
        }else{
            return $connect -> out_msg(0,'删除商品失败!');
        }
    }
    public function modifyProductStorage($product_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteProduct_sql = "update tssq_product set product_storage=product_storage-1,product_sale=product_sale+1 where product_id = '$product_id'";
        $conn ->query($deleteProduct_sql);
        $deleteProduct_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteProduct_rs){
            return $connect -> out_msg(1,'成功!');
        }else{
            return $connect -> out_msg(0,'失败!');
        }
    }


}



