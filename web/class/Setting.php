<?php

include_once "../../../config/db_config.php";
class Setting
{

    protected static $setting;

    public function __construct()
    {
    }

    public function selectSetting()
    {
        $selectSetting_sql = "select * from tssq_setting where setting_id = 1";
        $connect = db_config::getInstance();
        $conn = $connect->connect_bdb();
        $selectSetting_rs = $conn->query($selectSetting_sql);
        $conn->close();
        return $connect->out_msg(1, '', $selectSetting_row = $selectSetting_rs->fetch_assoc());
    }

    public function selectSetting2()
    {
        $selectSetting_sql = "select * from tssq_setting where setting_id = 1";
        $connect = db_config::getInstance();
        $conn = $connect->connect_bdb();
        $selectSetting_rs = $conn->query($selectSetting_sql);
        $conn->close();
        return $selectSetting_row = $selectSetting_rs->fetch_assoc();
    }

    public function modifySetting($logo_pic,$lunbo_pic,$notice_info,$instruction_sheet,$kefu_tel,$community_tel,$community_address,$use_info)
    {
        $connect = db_config::getInstance();
        $conn = $connect->connect_bdb();
							$updateSetting_sql = "update tssq_setting set logo_pic = '$logo_pic',lunbo_pic = '$lunbo_pic',notice_info = '$notice_info',instruction_sheet='$instruction_sheet',kefu_tel='$kefu_tel',community_tel='$community_tel',community_address='$community_address',use_info='$use_info' where setting_id = 1 ";
        $conn->query($updateSetting_sql);
        $updateSetting_rs = mysqli_affected_rows($conn);
        if ($updateSetting_rs) {
            $updateSetting_sql = "update xd_student set update_flag = 1 ";
            $conn->query($updateSetting_sql);
            $conn->close();
            return $connect->out_msg(1, '更新设置成功!');
        } else {
            return $connect->out_msg(0, '更新设置失败!');
        }
    }
}




