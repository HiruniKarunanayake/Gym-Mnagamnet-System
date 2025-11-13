<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
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
<title>Gym System</title>
<?php include 'includes/head.php'; ?>
<!-- Include Font Awesome for icons -->

<style>
    .status-icon {
        font-size: 1.2em;
    }
    .status-active {
        color: green;
    }
    .status-expired {
        color: red;
    }
</style>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include 'includes/header.php'; ?>
<!--close-top-Header-menu-->
<!--sidebar-menu-->
<?php $page = "membersts"; include 'includes/sidebar.php'; ?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a> <a href="member-status.php" class="current">Status</a> </div>
    <h1 class="text-center">Member's Current Status <i class="fa fa-eye"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='fa fa-th'></i> </span>
            <h5>Status table</h5>
          </div>
          <div class='widget-content nopadding'>
            <?php
            $customerList = Customer::getAllCustomers($con);
            $cnt = 1;
            echo "<table class='table table-bordered table-striped'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Contact Number</th>
                  <th>Choosen Service</th>
                  <th>Plan</th>
                  <th>Membership Status</th>
                </tr>
              </thead>";
            foreach ($customerList as $customer): ?>
              <tbody> 
                <tr>
                  <td><div class='text-center'><?php echo $cnt; ?></div></td>
                  <td><div class='text-center'><?php echo $customer->getFullName(); ?></div></td>
                  <td><div class='text-center'><?php echo $customer->getContact(); ?></div></td>
                  <td><div class='text-center'><?php echo $customer->getServices(); ?></div></td>
                  <td><div class='text-center'><?php echo $customer->getPlan(); ?> Days</div></td>
                  <td><div class='text-center'>
                      <?php if ($customer->getStatus() == 'Active') { ?>
                          <i class="fas fa-circle status-icon status-active"></i> Active
                      <?php } else { ?>
                          <i class="fas fa-circle status-icon status-expired"></i> Expired
                      <?php } ?>
                  </div></td>
                </tr>
              </tbody>
              <?php $cnt++; 
              endforeach; ?>
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
  function goPage (newURL) {
      if (newURL != "") {
          if (newURL == "-") {
              resetMenu();            
          } else {  
            document.location.href = newURL;
          }
      }
  }

  function resetMenu() {
     document.gomenu.selector.selectedIndex = 2;
  }
</script>
</body>
</html>
