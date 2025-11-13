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
<?php $page = "member"; include 'includes/sidebar.php'; ?>
<!--sidebar-menu-->

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="#" class="current">Registered Members</a> </div>
        <h1 class="text-center">Registered Members List <i class="fas fa-users"></i></h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class='widget-box'>
                    <div class='widget-title'> <span class='icon'> <i class='fas fa-th'></i> </span>
                        <h5>Member table</h5>
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
                                  <th>Username</th>
                                  <th>Gender</th>
                                  <th>Contact Number</th>
                                  <th>D.O.R</th>
                                  <th>Address</th>
                                  <th>Amount</th>
                                  <th>Choosen Service</th>
                                  <th>Plan</th>
                                </tr>
                              </thead>";

                        foreach ($customerList as $customer):

                        echo "<tbody> 
                                <tr>
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
                                </tr>
                              </tbody>";

                        $cnt++; endforeach;

                        echo "</table>";
                        ?>
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
    function goPage(newURL) {
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
