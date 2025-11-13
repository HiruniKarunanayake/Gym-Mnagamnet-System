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
<title>Gym System</title>
<?php include 'includes/head.php';?>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<?php include 'includes/header.php'?>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->

<!--sidebar-menu-->
<?php $page='payment'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<?php

$userId=$_GET['id'];
$customer= Customer::getCustomerByUserId($con, $userId);
?> 

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="payment.php">Payments</a> <a href="#" class="current">Invoice</a> </div>
    <h1>Payment Form</h1>
  </div>
  
  
  <div class="container-fluid" style="margin-top:-38px;">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-money"></i> </span>
            <h5>Payments</h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span5">
                <table class="">
                  <tbody>
                  <tr>
                      <td><img src="../img/gym-logo.png" alt="Gym Logo" width="175"></td>
                    </tr>
                    <tr>
                      <td><h4>The Bumz GYM</h4></td>
                    </tr>
                    <tr>
                      <td>No 12, Anagarika Dharmapala Mw, Matara</td>
                    </tr>
                    
                    <tr>
                      <td>Tel: +94 716405788</td>
                    </tr>
                    <tr>
                      <td >Email: support@bumzgym.com</td>
                    </tr>
                  </tbody>
                </table>
              </div>
			  
			  
              <div class="span7">
                <table class="table table-bordered table-invoice">
				
                  <tbody>
		<form action="userpay.php" method="POST">
                    <tr>
                    <tr>
                      <td class="width30">Member's Fullname:</td>
                    <input type="hidden" name="fullname" value="<?php echo $customer->getFullName(); ?>">
                    <td class="width70"><strong><?php echo $customer->getFullName(); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Service:</td>
                    <input type="hidden" name="services" value="<?php echo $customer->getServices(); ?>">
                    <td><strong><?php echo $customer->getServices(); ?></strong></td>
                    </tr>
                    <tr>
                      <td>Amount Per Month:</td>
                      <td><input id="amount" type="number" name="amount" value='<?php if($customer->getServices() == 'Fitness') { echo '55';} elseif ($customer->getServices() == 'Sauna') { echo '35';} else {echo '40';} ?>' /></td>
                    </tr>

                    <input type="hidden" name="paid_date" value="<?php echo $customer->getPaidDate(); ?>">
					
                  <td class="width30">Plan:</td>
                    <td class="width70">
					<div class="controls">
                <select name="plan" required="required" id="select">
                  <option value="1" selected="selected" >One Month</option>
                  <option value="3">Three Month</option>
                  <option value="6">Six Month</option>
                  <option value="12">One Year</option>
                  <option value="0">None-Expired</option>

                </select>
              </div>

             
			  
                      </td>
					  
					  <tr>
                     
                    </tr>
                  <td class="width30">Member's Status:</td>
                    <td class="width70">
					<div class="controls">
                <select name="status" required="required" id="select">
                  <option value="Active" selected="selected" >Active</option>
                  <option value="Expired">Expired</option>

                </select>
              </div>
			  

                      </td>
                  </tr>
                    </tbody>
                  
                </table>
              </div>
			  
			  
            </div> <!-- row-fluid ends here -->
			
			
            <div class="row-fluid">
              <div class="span12">
                
				
				<hr>
                <div class="text-center">
                  <!-- user's ID is hidden here -->

                  <input type="hidden" name="id" value="<?php echo $customer->getUserId();?>">
      
                  <button class="btn btn-success btn-large" type="SUBMIT" href="">Make Payment</button> 
				</div>
				  
				  </form>
              </div><!-- span12 ends here -->
            </div><!-- row-fluid ends here -->

          </div><!-- widget-content ends here -->
		  
		  
        </div><!-- widget-box ends here -->
      </div><!-- span12 ends here -->
    </div> <!-- row-fluid ends here -->
  </div> <!-- container-fluid ends here -->
</div> <!-- div id content ends here -->



<!--end-main-container-part-->

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

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