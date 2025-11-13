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
?>
 
<?php 
        
            if(isset($_POST['fullname'])){
            $fullName = $_POST["fullname"];    
            $username = $_POST["username"];
            $gender = $_POST["gender"];
            $contact = $_POST["contact"];
            $address = $_POST["address"];
            $designation = $_POST["designation"];
            $userId = $_POST["id"];
            $email=$_POST["email"];
            
            $previousResult= Staff::getStaffByUserId($con, $userId);
            
            $staffMember = new Staff(null, $username, $previousResult->getPassword(), $email, $fullName, $address, $designation, $gender, $contact);

            $result = $staffMember->updateStaffMember($con, $userId);

            if(!$result){
                echo"ERROR!!";
            }else {

                header('Location:staffs.php');

            }

            }else{
                echo"<h3>YOU ARE NOT AUTHORIZED TO REDIRECT THIS PAGE. GO BACK to <a href='index.php'> DASHBOARD </a></h3>";
            }
?>