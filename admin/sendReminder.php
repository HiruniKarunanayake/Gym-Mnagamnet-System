<?php

session_start();
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
require_once '../classes/DbConnector.php';
require_once '../classes/Reminder.php';

use classes\DbConnector;
use classes\Reminder;

$con= DbConnector::getConnection();

if(isset($_GET['id'])){
$userId=$_GET['id'];

$result= Reminder::sendReminderByUserId($con, $userId);

if($result){
    echo '<script>alert("Notification sent to selected customer!")</script>';
    echo '<script>window.location.href = "payment.php";</script>';
    
}else{
    echo"ERROR!!";
}
}
?> 