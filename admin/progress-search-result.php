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
<?php $page="manage-customer-progress"; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="customer-progress.php">Progress</a> <a href="#" class="current">Search Results</a> </div>
    <h1 class="text-center">Update Customer's Progress <i class="fas fa-signal"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fas fa-th'></i> </span>
            <h5>Progress table</h5>
            <form id="custom-search-form" role="search" method="POST" action="search-result.php" class="form-search form-horizontal pull-right">
                <div class="input-append span12">
                    <input type="text" class="search-query" placeholder="Search" name="search" required>
                    <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                </div>
            </form>
          </div>
          
          <div class='widget-content nopadding'>
	   
	  <?php

      $search=$_POST['search'];
      $cnt = 1;
      
        $customerList= Customer::searchCustomers($con, $search);

        if (!$customerList){

            echo"<div class='error_ex'>
            <h1>403</h1>
            <h3>Opps, Results Not Found!!</h3>
            <p>It seems like there's no such record available in our database.</p>
            <a class='btn btn-danger btn-big'  href='customer-progress.php'>Go Back</a> </div>'";
        }else{

        echo"<table class='table table-bordered table-hover'>
        <thead>
          <tr>
            <th>#</th>
            <th>Fullname</th>
            <th>Choosen Service</th>
            <th>Plan</th>
            <th>Action</th>
          </tr>
        </thead>";
            
    
            foreach ($customerList as $customer):

            echo"<tbody> 
               
                <td><div class='text-center'>".$cnt."</div></td>
                <td><div class='text-center'>".$customer->getFullName()."</div></td>
                <td><div class='text-center'>".$customer->getServices()."</div></td>
                <td><div class='text-center'>".$customer->getPlan()." Days</div></td>
                <td><div class='text-center'><a href='update-progress.php?id=".$customer->getUserId()."'><button class='btn btn-warning btn-mini'> Update Progress</button></a></div></td>
                
              </tbody>";
         $cnt++;
     endforeach;
        }
            ?>

            </table>
          </div>
        </div>
   
		
	
      </div>
    </div>
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

<style>
    #custom-search-form {
        margin:0;
        margin-top: 5px;
        padding: 0;
    }
 
    #custom-search-form .search-query {
        padding-right: 3px;
        padding-right: 4px \9;
        padding-left: 3px;
        padding-left: 4px \9;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
 
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    #custom-search-form button {
        border: 0;
        background: none;
        /** belows styles are working good */
        padding: 2px 5px;
        margin-top: 2px;
        position: relative;
        left: -28px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    .search-query:focus + button {
        z-index: 3;   
    }
</style>

<?php include 'includes/js_libraries.php'; ?>

</body>
</html>
