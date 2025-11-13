<?php

session_start();
//the isset function to check username is already loged in and stored on the session
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
}
require_once '../../classes/DbConnector.php';
require_once '../../classes/Customer.php';

use classes\DbConnector;
use classes\Customer;

$con = DbConnector::getConnection();

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $result= Customer::removeCustomerById($con, $userId);

    if ($result) {
        echo"DELETED";
        header('Location:../member-remove.php');
    } else {
        echo"ERROR!!";
    }
}
?>