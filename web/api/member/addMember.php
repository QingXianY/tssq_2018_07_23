<?php

include_once "../../class/Member.php";

$rid = $_POST['rid'];
$member_name = $_POST['member_name'];
$member_tel = $_POST['member_tel'];
$member_account = $_POST['member_account'];
$member_password = $_POST['member_password'];


$Member=new Member();

echo $Member->addMember($rid,$member_name,$member_tel,$member_account,$member_password);