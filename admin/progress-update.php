<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
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
<?php include 'includes/topheader.php'; ?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page = 'manage-customer-progress'; include 'includes/sidebar.php'; ?>
<!--sidebar-menu-->

<?php
$userId = $_GET['id'];
$customer = Customer::getCustomerByUserId($con, $userId);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
            <a href="customer-progress.php">Customer Progress</a>
            <a href="#" class="current">Update Progress</a>
        </div>
        <h1 class="text-center">Update Customer's Progress <i class="fas fa-signal"></i></h1>
    </div>
  
    <div class="container-fluid" style="margin-top:-38px;">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fas fa-signal"></i></span>
                        <h5>Progress</h5>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span2"></div>
                            <div class="span8">
                                <table class="table table-bordered table-invoice">
                                    <tbody>
                                        <form action="progress-req.php" method="POST">
                                            <tr>
                                                <td class="width30">Member's Fullname:</td>
                                                <td class="width70"><strong><?php echo $customer->getFullName(); ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Service Taken:</td>
                                                <td><strong><?php echo $customer->getServices(); ?></strong></td> <!-- Assuming you have this method in your Customer class -->
                                            </tr>
                                            <tr>
                                                <td>Initial Weight: (KG)</td>
                                                <td><input id="weight" type="number" name="ini_weight" value='<?php echo $customer->getInitialWeight(); ?>' /></td> <!-- Assuming you have this method in your Customer class -->
                                            </tr>
                                            <tr>
                                                <td>Current Weight: (KG)</td>
                                                <td><input id="weight" type="number" name="curr_weight" value='<?php echo $customer->getCurrentWeight(); ?>' /></td> <!-- Assuming you have this method in your Customer class -->
                                            </tr>
                                            <tr>
                                                <td>Initial Body Type:</td>
                                                <td><input id="ini_bodytype" type="text" name="ini_bodytype" value='<?php echo $customer->getInitialBodyType(); ?>' /></td> <!-- Assuming you have this method in your Customer class -->
                                            </tr>
                                            <tr>
                                                <td>Current Body Type:</td>
                                                <td><input id="curr_bodytype" type="text" name="curr_bodytype" value='<?php echo $customer->getCurrentBodyType(); ?>' /></td> <!-- Assuming you have this method in your Customer class -->
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <input type="hidden" name="id" value="<?php echo $userId; ?>">
                                                    <button class="btn btn-primary btn-large" type="submit">Save Changes</button>
                                                </td>
                                            </tr>
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- row-fluid ends here -->

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="text-center"></div>
                            </div> <!-- span12 ends here -->
                        </div> <!-- row-fluid ends here -->
                    </div> <!-- widget-content ends here -->
                </div> <!-- widget-box ends here -->
            </div> <!-- span12 ends here -->
        </div> <!-- row-fluid ends here -->
    </div> <!-- container-fluid ends here -->
</div> <!-- div id content ends here -->

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

<?php include 'includes/js_libraries.php'; ?>

</body>
</html>
