<?php

session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
require_once '../classes/DbConnector.php';
require_once '../classes/Staff.php';

use classes\DbConnector;
use classes\Staff;

$con = DbConnector::getConnection();

if(isset($_GET['id'])){
$userId=$_GET['id'];

$result= Staff::removeStaffMemberById($con, $userId);

if($result){
    echo"DELETED";
    header('Location:staffs.php');
}else{
    echo"ERROR!!";
}
}
?>