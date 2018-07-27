<?php

include_once "../../class/Setting.php";

$logo_pic = $_POST['logo_pic'];
$lunbo_pic = $_POST['lunbo_pic'];
$notice_info = $_POST['notice_info'];
$instruction_sheet = $_POST['instruction_sheet'];
$kefu_tel = $_POST['kefu_tel'];
$community_tel = $_POST['community_tel'];
$community_address = $_POST['community_address'];
$use_info = $_POST['use_info'];

$Setting = new Setting();

echo $Setting->modifySetting($logo_pic,$lunbo_pic,$notice_info,$instruction_sheet,$kefu_tel,$community_tel,$community_address,$use_info);

