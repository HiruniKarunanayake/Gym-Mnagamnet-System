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
<?php $page="member"; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="remove-member.php" class="current">Remove Members</a> </div>
    <h1 class="text-center">Remove Members <i class="fa fa-user-times"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fa fa-th'></i> </span>
            <h5>Member table</h5>
          </div>
          <div class='widget-content nopadding'>
	  
	  <?php

      $customerList= Customer::getAllCustomers($con);
      $cnt=1;

        
          echo"<table class='table table-bordered table-hover'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Username</th>
                  <th>Gender</th>
                  <th>Contact Number</th>
                  <th>D.O.R</th>
                  <th>Address</th>
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
                <td><div class='text-center'>@".$customer->getUsername()."</div></td>
                <td><div class='text-center'>".$customer->getGender()."</div></td>
                <td><div class='text-center'>".$customer->getContact()."</div></td>
                <td><div class='text-center'>".$customer->getRegistrationDate()."</div></td>
                <td><div class='text-center'>".$customer->getAddress()."</div></td>
                <td><div class='text-center'>$".$customer->getAmount()."</div></td>
                <td><div class='text-center'>".$customer->getServices()."</div></td>
                <td><div class='text-center'>".$customer->getPlan()." Days</div></td>
                <td><div class='text-center'><a href='actions/delete-member.php?id=".$customer->getUserId()."' style='color:#F66;'><i class='fas fa-trash'></i> Remove</a></div></td>
                
              </tbody>";
           $cnt++; endforeach;
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
