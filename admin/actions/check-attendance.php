<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');    
}

require_once '../../classes/DbConnector.php';
require_once '../../classes/Customer.php';
require_once '../../classes/Attendance.php';

use classes\DbConnector;
use classes\Customer;
use classes\Attendance;

$con = DbConnector::getConnection();

date_default_timezone_set('Asia/Colombo');
$currentDateTime = date('Y-m-d h:i A');
$expDateTime = explode(' ', $currentDateTime);
$currentDate = $expDateTime[0];
$currentTime = $expDateTime[1] . ' ' . $expDateTime[2];

$userId = $_GET['id'];

$present = "1";
$attendance = new Attendance(null, $userId, $currentDate, $currentTime, $present);

if ($attendance->addAttendance($con)) {
    $resultAttend = Customer::getCustomerByUserId($con, $userId);
    
    if ($resultAttend) {
        $attendCount = $resultAttend->getAttendanceCount();
        $attendCount += 1;
        if (Customer::updateAttendance($con, $userId, $attendCount)) {
            // Attendance and customer records updated successfully
            $_SESSION['success'] = 'Record Successfully Added';
        } else {
            // Failed to update customer attendance count
            $_SESSION['error'] = 'Failed to update customer attendance count';
        }
    } else {
        // Failed to retrieve customer data
        $_SESSION['error'] = 'Failed to retrieve customer data';
    }
} else {
    // Failed to add attendance record
    $_SESSION['error'] = 'Something Went Wrong';
}

header('location:../attendance.php');
exit();
?>
