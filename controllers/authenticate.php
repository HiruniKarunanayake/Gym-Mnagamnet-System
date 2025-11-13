<?php
session_start();
require_once '../classes/Admin.php';
require_once '../classes/DbConnector.php';

use classes\Admin;
use classes\DbConnector;

if (isset($_POST['username'], $_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; 

    $con = DbConnector::getConnection();

    $admin = new Admin(null, $username, $password, null);
    $result = $admin->authenticate($con);

    if ($result) {
        $_SESSION['user_id'] = $admin->getUserId();
        $location = "../admin/index.php";
    } else {
        $location = "../index.php?status=1"; // Authentication failed
    }

    header("Location: " . $location);
    exit();
}
?>
