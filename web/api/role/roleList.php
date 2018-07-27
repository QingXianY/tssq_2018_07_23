<?php

include_once "../../class/Role.php";

$role_name = isset($_GET['role_name'])?$_GET['role_name']:null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
//$Role = Role::getInstance();
$Role = new Role();
echo $Role->getRoleList($page,$rows,$role_name);

