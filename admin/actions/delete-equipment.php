<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');

}
require_once '../../classes/DbConnector.php';
require_once '../../classes/Equipment.php';

use classes\DbConnector;
use classes\Equipment;

$con = DbConnector::getConnection();

if(isset($_GET['id'])){
$id=$_GET['id'];



$result= Equipment::removeEquipment($con, $id);

if($result){
    echo"DELETED";
    header('Location:../equipment-remove.php');
}else{
    echo"ERROR!!";
}
}
?>