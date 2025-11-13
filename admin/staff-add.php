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
 
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin</title>
<?php include 'includes/head.php'; ?>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>

 
<!--sidebar-menu-->
  <?php $page='staff-management'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="staffs.php">Staffs</a> <a href="staffs-entry.php" class="current">Staff Entry</a> </div>
    <h1 class="text-center">GYM's Staff <i class="fas fa-users"></i></h1>
  </div>
  
  <form role="form" action="index.php" method="POST">
            <?php 

            if(isset($_POST['fullname'])){
            $fullName = $_POST["fullname"];    
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $address = $_POST["address"];
            $designation = $_POST["designation"];
            $gender = $_POST["gender"];
            $contact = $_POST["contact"];

            $password = md5($password);

            $staffMember = new Staff(null, $username, $password, $email, $fullName, $address, $designation, $gender, $contact);
            $result = $staffMember->register($con);

                    if(!$result){
                    echo"<div class='container-fluid'>";
                        echo"<div class='row-fluid'>";
                        echo"<div class='span12'>";
                        echo"<div class='widget-box'>";
                        echo"<div class='widget-title'> <span class='icon'> <i class='fas fa-info'></i> </span>";
                            echo"<h5>Error Message</h5>";
                            echo"</div>";
                            echo"<div class='widget-content'>";
                                echo"<div class='error_ex'>";
                                echo"<h1 style='color:maroon;'>Error 404</h1>";
                                echo"<h3>Error occured while submitting your details</h3>";
                                echo"<p>Please Try Again</p>";
                                echo"<a class='btn btn-warning btn-big'  href='member-edt.php'>Go Back</a> </div>";
                            echo"</div>";
                            echo"</div>";
                        echo"</div>";
                        echo"</div>";
                    echo"</div>";
                    }else {

                    echo"<div class='container-fluid'>";
                        echo"<div class='row-fluid'>";
                        echo"<div class='span12'>";
                        echo"<div class='widget-box'>";
                        echo"<div class='widget-title'> <span class='icon'> <i class='fas fa-info'></i> </span>";
                            echo"<h5>Message</h5>";
                            echo"</div>";
                            echo"<div class='widget-content'>";
                                echo"<div class='error_ex'>";
                                echo"<h1>Success</h1>";
                                echo"<h3>Staff details has been added!</h3>";
                                echo"<p>The requested staff details are added to database. Please click the button to go back.</p>";
                                echo"<a class='btn btn-inverse btn-big'  href='staffs.php'>Go Back</a> </div>";
                            echo"</div>";
                            echo"</div>";
                        echo"</div>";
                        echo"</div>";
                    echo"</div>";

                    }
                    //  
                    }else{
                        echo"<h3>YOU ARE NOT AUTHORIZED TO REDIRECT THIS PAGE. GO BACK to <a href='index.php'> DASHBOARD </a></h3>";
                    }
?>                                    
                                    </form>
                                </div>

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

<?php include 'includes/js_libraries.php'; ?>
</body>
</html>
