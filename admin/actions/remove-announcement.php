<?php

session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
require_once '../../classes/DbConnector.php';
require_once '../../classes/Announcement.php';

use classes\DbConnector;
use classes\Announcement;

$con = DbConnector::getConnection();

if(isset($_GET['id'])){
$announcementId=$_GET['id'];

$result= Announcement::removeAnnouncement($con, $announcementId);

if($result){
    echo"DELETED";
    header('Location:../announcement.php');
}else{
    echo"ERROR!!";
}
}
?>