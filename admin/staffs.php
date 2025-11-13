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
<!--close-top-Header-menu-->
 
<!--sidebar-menu-->
<?php $page='staff-management'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="staffs.php" class="current">Staff Members</a> </div>
    <h1 class="text-center">GYM's Staff List <i class="fas fa-briefcase"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <a href="staffs-entry.php"><button class="btn btn-primary">Add Staff Members</button></a>
      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fas fa-th'></i> </span>
            <h5>Staff table</h5>
          </div>
          <div class='widget-content nopadding'>
	  
	  <?php

      
      $cnt=1;
        $staffList= Staff::getAllStaffMembers($con);

        
          echo"<table class='table table-bordered table-hover'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Username</th>
                  <th>Gender</th>
                  <th>Designation</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Actions</th>
                </tr>
              </thead>";
              
            foreach ($staffList as $staff):
            
            echo"<tbody> 
                <tr class=''>
                <td><div class='text-center'>".$cnt."</div></td>
                <td><div class='text-center'>".$staff->getFullName()."</div></td>
                <td><div class='text-center'>@".$staff->getUsername()."</div></td>
                <td><div class='text-center'>".$staff->getGender()."</div></td>
                <td><div class='text-center'>".$staff->getDesignation()."</div></td>
                <td><div class='text-center'>".$staff->getEmail()."</div></td>
                <td><div class='text-center'>".$staff->getAddress()."</div></td>
                <td><div class='text-center'>".$staff->getContact()."</div></td>
                <td><div class='text-center'><a href='staff-edit-form.php?id=".$staff->getUserId()."'><i class='fas fa-edit' style='color:#28b779'></i> Edit |</a> <a href='staff-remove.php?id=".$staff->getUserId()."' style='color:#F66;'><i class='fas fa-trash'></i> Remove</a></div></td>
                </tr>
                
              </tbody>";
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
</body>
</html>
