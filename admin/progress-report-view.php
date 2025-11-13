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
<?php $page='c-p-r'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="member-report.php" class="current">Member Reports</a> </div>
    <h1 class="text-center">Progress Report <i class="fas fa-tasks"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
	          <div class="widget-box">
      <?php
            
            $userId=$_GET['id'];
            $customer= Customer::getCustomerByUserId($con, $userId);
            ?> 
      
     <div class="widget-content">
            <div class="row-fluid">
              <div class="span4">
                <table class="">
                  <tbody>
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
              
              <div class="span8">
                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Membership ID</th>
                      <th class="head1 right">Initial Weight</th>
                      <th class="head0 right">Current Weight</th>
                      <th class="head1">Services Taken</th>
                      <th class="head0 right">Plans (Upto)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><div class="text-center">PGC-SS-<?php echo $customer->getUserId(); ?></div></td>
                      <td><div class="text-center"><?php echo $customer->getInitialWeight(); ?> KG</div></td>
                      <td><div class="text-center"><?php echo $customer->getCurrentWeight(); ?> KG</div></td>
                      <td><div class="text-center"><?php echo $customer->getServices(); ?></div></td>
                      <td><div class="text-center"><?php echo $customer->getPlan(); ?> Month/s</div></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered table-invoice-full">
                  <tbody>
                    <tr>
                        <td class="msg-invoice" width="55%"> <div class="text-center"><h5><?php echo $customer->getFullName(); ?>'s Body Structure stated as from <?php echo $customer->getInitialBodyType(); ?> to <?php echo $customer->getCurrentBodyType(); ?>. <br /> With Total Weight Differences of <?php echo Customer::getWeightDifferance($con, $userId) ;?> KG <br /> As per records of <?php echo $customer->getProgressDate(); ?></h5>
                        
                        </div>
                    </tr>
                  </tbody>
                </table>
              </div> <!-- end of span 12 -->
              
            </div>

            <div class="row-fluid">
                <div class="pull-left">
                <br>
                
                <h4>GYM Member: <?php echo $customer->getFullName(); ?> <br> Weight Variation of <em style="color:green"><?php echo Customer::getProgressPercentage($con, $userId);?>%</em> as per current updates! <i class="fa fa-spinner fa-spin" style="font-size:24px"></i><br/> <br/>  <br/></h4><p>Thank you for choosing our services.<br/>- on the behalf of whole team</p>
                </div>
                <div class="pull-right">
                  <h4><span>Approved By:</h4>
                  <img src="../img/report/stamp-sample.png" width="124px;" alt=""><p class="text-center">Note:AutoGenerated</p> </div>
                  
            </div>
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
