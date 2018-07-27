<?php

include_once "../../class/Role.php";

$role_name = $_POST['role_name'];
$role_amount = $_POST['role_amount'];
$role_competence = $_POST['role_competence'];

$Role=new Role();

echo $Role->addRole($role_name,$role_amount,$role_competence);