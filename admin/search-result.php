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

$con= DbConnector::getConnection();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin</title>
<?php include 'includes/head.php';?>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>


<!--sidebar-menu-->
<?php $page='payment'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="payment.php">Payments</a> <a href="#" class="current">Search Results</a> </div>
    <h1 class="text-center">Registered Member's Payment <i class="fas fa-group"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fas fa-th'></i> </span>
            <h5>Member's Payment table</h5>
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
            <th>Last Payment Date</th>
            <th>Amount</th>
            <th>Choosen Service</th>
            <th>Plan</th>
            <th>Action</th>
          </tr>
        </thead>";
            
    
            foreach ($customerList as $customer):

                
            
            echo"<tbody> 
               
                <td><div class='text-center'>".$cnt."</div></td>
                <td><div class='text-center'>".$customer->getFullName()."</div></td>
                <td><div class='text-center'>".$customer->getPaidDate()."</div></td>
                <td><div class='text-center'>$".$customer->getAmount()."</div></td>
                <td><div class='text-center'>".$customer->getServices()."</div></td>
                <td><div class='text-center'>".$customer->getPlan()." Days</div></td>
                <td><div class='text-center'><a href='user-payment.php?id=".$customer->getUserId()."'><button class='btn btn-success btn'><i class='fas fa-dollar-sign'></i> Make Payment</button></a></div></td>
                
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

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
