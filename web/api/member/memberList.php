<?php

include_once "../../class/Member.php";

$mid = isset($_GET['mid'])?$_GET['mid']:null;
$rid = isset($_GET['rid'])?$_GET['rid']:null;
$member_name = isset($_GET['member_name'])?$_GET['member_name']:null;
$member_tel = isset($_GET['member_tel'])?$_GET['member_tel']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

$Member = new Member();

echo $Member->getMemberList($page,$rows,$mid,$rid,$member_name,$member_tel);



