<?php
include_once "../../../config/db_config.php";
include_once "../../../config/get_time.php";
include_once "Detail.php";
include_once "User.php";
include_once "Product.php";

class Order{
    private $orderList;

    public function __construct(){}

    public function selectOrderById($order_code){
        $selectOrder_sql = "select * from v_order_stu_pro where order_code = '$order_code'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectOrder_rs=$conn ->query($selectOrder_sql);
        $conn -> close();
        return $selectOrder_row = $selectOrder_rs -> fetch_assoc();
    }

    //获取订单列表
    public function getOrderList($page,$rows,$order_code,$order_status,$volunteer_id,$start_date,$end_date){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1 ";

        if(!empty($order_code)){
            $where.= " and order_code = '$order_code'";
        }
        if($order_status!=''){
            $where.= " and order_status = '$order_status'";
        }
        if(!empty($volunteer_id)){
            $where.= " and volunteer_id = '$volunteer_id'";
        }
        if($start_date){
            $where.= " and order_time >= '$start_date' ";
        }
        if($end_date){
            $where.= " and order_time <= '$end_date' ";
        }
        $orderList_sql = "select * from v_volunteer_order ".$where." order by order_time desc "." limit $offset,$rows";  //sql查询语句，根据订单编号查询
        $orderList_rs=$conn ->query($orderList_sql);
        $orderListCount_sql = "select count(*) from v_volunteer_order ".$where;  //sql查询语句，根据角色姓名模糊查询
        $orderListCount_rs=$conn ->query($orderListCount_sql);
        $row=$orderListCount_rs -> fetch_row();
        $count=$row[0];
        $conn -> close();
        $orderList=array();
        while($orderList_row = $orderList_rs -> fetch_assoc()){
            array_push($orderList,$orderList_row);
        }
         
        return $connect -> out_msg2(1,'',$count,$this->orderList = $orderList);
    }

    //用户下单,成功下单后订单状态为 0 ：待确认（小程序）/待核销（后台）
    public function addOrder($volunteer_id,$product_id){
        $connect= db_config::getInstance();
        $get_time = new get_time();
        $present = $get_time->get_now_sec();
        $conn=$connect->connect_bdb();
        $insertOrder_sql = "insert into tssq_porder(volunteer_id,product_id,order_time,order_status) VALUE('$volunteer_id','$product_id',null,0)";
        $conn ->query($insertOrder_sql);
        $insertOrder_rs=mysqli_affected_rows($conn);
        if($insertOrder_rs){
            //获得商品价格
            $Product = new Product();
            $product_price = $Product->selectProductById($product_id)['product_price'];
            $Product->modifyProductStorage($product_id);
            //修改积分
            $user = new User();
            $user->modifyIntegral($volunteer_id,0,'积分兑换',$product_price);
            $userinfo=$user->selectById($volunteer_id);
            $conn -> close();
            return $connect -> out_msg(1,'下单成功!',$userinfo['volunteer_integral']);
        }else{
            return $connect -> out_msg(0,'下单失败，请检查后重试!');
        }
    }

    //取消订单，修改订单状态为 2 ：已取消
    public function cancelOrder($order_code){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $updateOrder_sql = "update tssq_porder set order_status = 2 where order_code = '$order_code' ";
        $conn ->query($updateOrder_sql);
        $updateOrder_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($updateOrder_rs){

            //获得商品价格
            $product_price = $this->selectOrderById($order_code)['product_price'];
            $volunteer_id = $this->selectOrderById($order_code)['volunteer_id'];

            //修改积分
            $Student = new Student();
            $Student->modifyStudentIntegral($volunteer_id,1,'订单退款',$product_price);

            return $connect -> out_msg(1,'取消订单成功!');
        }else{
            return $connect -> out_msg(0,'取消订单失败，请检查后重试!');
        }
    }

    //核销订单，修改订单状态为 1 ：已完成
    public function checkOrder($order_code){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $updateOrder_sql = "update tssq_porder set order_status = 1 where order_code = '$order_code' ";
        $conn ->query($updateOrder_sql);
        $updateOrder_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($updateOrder_rs){
            return $connect -> out_msg(1,'核销订单成功!');
        }else{
            return $connect -> out_msg(0,'核销订单失败，请检查后重试!');
        }
    }

    //删除订单
    public function deleteOrder($order_code){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteOrder_sql = "delete from tssq_porder where order_code = '$order_code'";
        $conn ->query($deleteOrder_sql);
        $deleteOrder_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteOrder_rs){
            return $connect -> out_msg(1,'删除订单成功!');
        }else{
            return $connect -> out_msg(0,'删除订单失败，请检查后重试!');
        }
    }


}



