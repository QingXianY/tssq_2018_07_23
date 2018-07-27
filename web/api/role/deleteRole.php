<?php

include_once "../../class/Role.php";

$rid = $_GET['rid'];

//$Role = Role::getInstance();
$Role = new Role();
echo $Role->deleteRole($rid);