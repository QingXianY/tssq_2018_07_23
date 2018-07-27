<?php

include_once "../../class/Member.php";

$mid = $_GET['mid'];

$Member = new Member();

echo $Member->deleteMember($mid);