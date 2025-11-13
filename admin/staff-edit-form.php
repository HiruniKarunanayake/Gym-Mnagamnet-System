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
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->

<!--sidebar-menu-->
<?php $page='staff-management'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<?php
$userId=$_GET['id'];
$staffMember= Staff::getStaffByUserId($con, $userId);

?> 

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="staffs.php" class="tip-bottom">Staffs</a> <a href="staff-edit-form.php" class="current">Edit Staff Records</a> </div>
  <h1 class="text-center">Update Staff's Detail <i class="fas fa-briefcase"></i></h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="fas fa-align-justify"></i> </span>
          <h5>Staff-Details</h5>
        </div>
        <div class="widget-content nopadding">

          <form action="staff-edit-req.php" method="POST" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Full Name :</label>
              <div class="controls">
                <input type="text" class="span11" name="fullname" value='<?php echo $staffMember->getFullName(); ?>' />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Username :</label>
              <div class="controls">
                  <input type="text" class="span11" name="username" value='<?php echo $staffMember->getUsername(); ?>' />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Password :</label>
              <div class="controls">
                <input type="password"  class="span11" name="password" disabled="" placeholder="**********"  />
                <span class="help-block">Note: Only the members are allowed to change their password until and unless it's an emergency.</span>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Gender :</label>
              <div class="controls">
                  <input type="text" class="span11" name="gender" value='<?php echo $staffMember->getGender(); ?>' />
              </div>
            </div>
        </div>
        <div class="widget-content nopadding">
          <div class="form-horizontal">
           
        </div>
        <div class="widget-content nopadding">
          
          </div>
        </div>
      </div>
    </div>
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="fas fa-align-justify"></i> </span>
          <h5>Staff-Details</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="form-horizontal">
            <div class="control-group">
              <label for="normal" class="control-label">Contact Number</label>
              <div class="controls">
                  <input type="number" id="mask-phone" name="contact" value='<?php echo $staffMember->getContact(); ?>' class="span8 mask text">
                <span class="help-block blue span8">(071) 456 2547</span> 
                </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">Email :</label>
              <div class="controls">
                  <input type="email" class="span11" name="email" value='<?php echo $staffMember->getEmail(); ?>' />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Address :</label>
              <div class="controls">
                  <input type="text" class="span11" name="address" value='<?php echo $staffMember->getAddress(); ?>' />
              </div>
            </div>
			
            <div class="control-group">
                  <label class="control-label">Designation</label>
                  <div class="controls">
                  <select name="designation" id="designation">
                    <option value="Cashier">Cashier</option>
                    <option value="Trainer">Trainer</option>
                    <option value="GYM Assistant">GYM Assistant</option>
                    <option value="Front Desk Staff">Front Desk Staff</option>
                    <option value="Manager">Manager</option>
                    </select>
                  </div>
                </div>	
          </div>
            <div class="form-actions text-center">
             <!-- user's ID is hidden here --> 
             <input type="hidden" name="id" value="<?php echo $staffMember->getUserId();?>">
              <button type="submit" class="btn btn-success">Update Staff Details</button>
            </div>

            </form>

          </div>
        </div>
        </div>
      </div>
  </div>
  <div class="row-fluid"> 
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