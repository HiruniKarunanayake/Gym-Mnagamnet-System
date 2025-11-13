<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
    header('location:../index.php');    
}
require_once '../classes/DbConnector.php';
require_once '../classes/Customer.php';
require_once '../classes/Attendance.php';

use classes\DbConnector;
use classes\Customer;
use classes\Attendance;

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
<?php include 'includes/header.php'?>

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
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a> <a href="attendance.php" class="current">Manage Attendance</a> </div>
    <h1 class="text-center">Attendance List <i class="fa fa-list"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fa fa-th'></i> </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'>
	  
	  <?php
          echo "<table class='table table-bordered'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Contact Number</th>
                  <th>Choosen Service</th>
                  <th>Action</th>
                </tr>
              </thead>";

              date_default_timezone_set('Asia/Colombo');
              $current_date = date('Y-m-d h:i A');
              $exp_date_time = explode(' ', $current_date);
              $todays_date = $exp_date_time[0];
                
              $customerList = Customer::getActiveCustomers($con);
              $cnt = 1;

              foreach ($customerList as $customer):
            ?>
            
           <tbody> 
               <tr>
                <td><div class='text-center'><?php echo $cnt; ?></div></td>
                <td><div class='text-center'><?php echo $customer->getFullName(); ?></div></td>
                <td><div class='text-center'><?php echo $customer->getContact(); ?></div></td>
                <td><div class='text-center'><?php echo $customer->getServices(); ?></div></td>

                <input type="hidden" name="user_id" value="<?php echo $customer->getUserId();?>">

            <?php
            $attendance = new Attendance(null, $customer->getUserId(), $todays_date, null, null);
             
            $num_count = $attendance->getAttendanceCount($con);
            $row_exist = $attendance->getAttendance($con, $customer->getUserId());

            if ($row_exist !== null && $row_exist->getCurrentDate() == $todays_date) {
            ?>
                <td>
                    <div class='text-center'><span class="label label-inverse"><?php echo $row_exist->getCurrentDate();?>  <?php echo $row_exist->getCurrentTime();?></span></div>
                    <div class='text-center'><a href='actions/delete-attendance.php?id=<?php echo $attendance->getUserId();?>'><button class='btn btn-danger'>Check Out <i class="fa fa-clock-o" aria-hidden="true"></i>
</button></a></div>
                </td>
            <?php
            } else {
            ?>
                <td>
                    <div class='text-center'><a href='actions/check-attendance.php?id=<?php echo $attendance->getUserId();?>'><button class='btn btn-info'>Check In <i class='fa fa-street-view'></i></button></a></div>
                </td>
            <?php 
                $cnt++;
            }
            ?>

              </tr>
              </tbody>

           <?php endforeach; ?>
           

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

</body>
</html>
