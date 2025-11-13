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
<?php include 'includes/head.php';?>
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
<?php $page="attendance"; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="attendance.php" class="current">Manage Attendance</a> </div>
    <h1 class="text-center">Attendance List <i class="fas fa-calendar"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fas fa-th'></i> </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'> 

        
          <table class='table table-bordered'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Plan</th>
                  <th>Attendance Count</th> 
                </tr>
              </thead>

             <?php 
              
             $customerList=Customer::getActiveCustomers($con);
                   
              $cnt = 1;
            foreach ($customerList as $customer): ?>
            
           <tbody> 
               
                <td><div class='text-center'><?php echo $cnt; ?></div></td>
                <td><div class='text-center'><?php echo $customer->getFullName(); ?></div></td>
                <td><div class='text-center'><?php if($customer->getPlan() == 1) { echo $customer->getPlan(). ' Month';} else if($customer->getPlan() == '0') { echo'Expired';} else { echo $customer->getPlan(). ' Months'; } ?></div></td>
                <td><div class='text-center'><?php if($customer->getAttendanceCount() == 1) { echo $customer->getAttendanceCount(). ' Day';} else if($customer->getAttendanceCount() == '0') { echo'None';} else { echo $customer->getAttendanceCount(). ' Days'; } ?>  </div></td>
              </tbody>
           <?php 
           $cnt++; 
           endforeach; 
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

</script>
</body>
</html>
