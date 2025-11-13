<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
require_once '../classes/DbConnector.php';
require_once '../classes/Customer.php';

use classes\DbConnector;
use classes\Customer;

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
<!--close-top-Header-menu-->
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->
 
<!--sidebar-menu-->
<?php $page='manage-customer-progress'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="customer-progress.php" class="tip-bottom">Progress Form</a> <a href="#" class="current">Update Progress</a> </div>
  <h1 class="text-center">Update Customer's Progress <i class="fas fa-signal"></i></h1>
</div>
<form role="form" action="index.php" method="POST">
    <?php 

            if(isset($_POST['ini_weight'])){ 
            $initialWeight = $_POST["ini_weight"];
            $currentWeight = $_POST["curr_weight"];
            $initialBodyType = $_POST["ini_bodytype"];
            $currentBodyType = $_POST["curr_bodytype"];
            $userId=$_POST['id'];
            
            
            date_default_timezone_set('Asia/Colombo');
            //$current_date = date('Y-m-d h:i:s');
            $current_date = date('Y-m-d h:i A');
            $exp_date_time = explode(' ', $current_date);
            $progressDate =  $exp_date_time['0'];
            $curr_time =  $exp_date_time['1']. ' ' .$exp_date_time['2'];
            
            $previousResult= Customer::getCustomerByUserId($con, $userId);
            $customer = new Customer(null,$previousResult->getFullName() , $previousResult->getUsername(), $previousResult->getPassword(), 
                    $previousResult->getGender(), $previousResult->getRegistrationDate(), $previousResult->getServices(), $previousResult->getAmount(), 
                    $previousResult->getPaidDate(), $previousResult->getPaidYear(), $previousResult->getPlan(), $previousResult->getAddress(),
                    $previousResult->getContact(), $previousResult->getStatus(), $previousResult->getAttendanceCount(), 
                    $initialWeight, 
                    $currentWeight, 
                    $initialBodyType, 
                    $currentBodyType, $progressDate, $previousResult->getReminder());
            
            $result = $customer->setProgressByUserId($con,$userId);

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
                            echo"<h3>Error occured while updating your details</h3>";
                            echo"<p>Please Try Again</p>";
                            echo"<a class='btn btn-warning btn-big'  href='customer-progress.php'>Go Back</a> </div>";
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
                    echo"<div class='widget-title'> <span class='icon'> <i class='fas fa-briefcase'></i> </span>";
                        echo"<h5>Administrator</h5>";
                        echo"</div>";
                        echo"<div class='widget-content'>";
                            echo"<div class='error_ex'>";
                            echo"<h1>Successfull</h1>";
                            echo"<h3>Changes Done Succefully!</h3>";
                            echo"<p>The requested user's progress has been updated. Please click the button to go back.</p>";
                            echo"<a class='btn btn-inverse btn-big'  href='index.php'>Return Home</a> </div>";
                        echo"</div>";
                        echo"</div>";
                    echo"</div>";
                    echo"</div>";
                echo"</div>";

            }

            }else{
                echo"<h3>YOU ARE NOT AUTHORIZED TO REDIRECT THIS PAGE. GO BACK to <a href='index.php'> DASHBOARD </a></h3>";
            }
?>
                                                               
                
             </form>
         </div>


<!--end-main-container-part-->

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

<?php include 'includes/js_libraries.php'; ?>


</body>
</html>
