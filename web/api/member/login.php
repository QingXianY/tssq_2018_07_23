<?php

include_once "../../class/Member.php";

$member_account = $_POST['member_account'];
$member_password = $_POST['member_password'];

$Member=new Member();

echo $Member->login($member_account,$member_password);