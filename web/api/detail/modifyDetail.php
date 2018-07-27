<?php

include_once "../../class/Role.php";

$rid = $_POST['rid'];
$role_name = $_POST['role_name'];
$role_amount = $_POST['role_amount'];
$Role = new Role();

echo $Role->modifyRole($rid,$role_name,$role_amount);

