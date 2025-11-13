<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}

require_once '../../classes/DbConnector.php';
require_once '../../classes/Attendance.php';

use classes\DbConnector;
use classes\Attendance;

$con = DbConnector::getConnection();
$userId = $_GET['id'];


$attendance = new Attendance(null, $userId, null, null, null);
$res = $attendance->removeAttendance($con);


//  $resultAttend = Customer::getCustomerByUserId($con, $userId);
//  $cnt = $resultAttend->getAttendanceCount();
// $attendCount = $cnt  - 1;
//  $sql1 = Customer::updateAttendance($con, $userId, $attendCount);
?>
<script>
// alert("Delete Successfully");
window.location = "../attendance.php";
</script>


 