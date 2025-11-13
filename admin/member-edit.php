<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit;
}

require_once '../classes/DbConnector.php';
require_once '../classes/Customer.php';

use classes\DbConnector;
use classes\Customer;

$con = DbConnector::getConnection();
$customerList = Customer::getAllCustomers($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System</title>
    <?php include 'includes/head.php'; ?>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Ensure your other CSS files are included here if necessary -->
</head>
<body>
 
<!-- Header -->
<div id="header">
    <h1><a href="dashboard.html">Perfect Gym</a></h1>
</div>

<!-- Top Header Menu -->
<?php include 'includes/header.php'; ?>

<!-- Sidebar Menu -->
<?php $page = "member"; include 'includes/sidebar.php'; ?>

<!-- Main Content -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> 
            <a href="#" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a> 
            <a href="#" class="current">Registered Members</a> 
        </div>
        <h1 class="text-center">Registered Members List <i class="fa fa-users"></i></h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> 
                        <span class="icon"> <i class="fa fa-th"></i> </span>
                        <h5>Member Table</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Gender</th>
                                    <th>Contact Number</th>
                                    <th>D.O.R</th>
                                    <th>Address</th>
                                    <th>Amount</th>
                                    <th>Chosen Service</th>
                                    <th>Plan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customerList as $cnt => $customer): ?>
                                    <tr>
                                        <td><?php echo $cnt + 1; ?></td>
                                        <td><?php echo $customer->getFullName(); ?></td>
                                        <td>@<?php echo $customer->getUsername(); ?></td>
                                        <td><?php echo $customer->getGender(); ?></td>
                                        <td><?php echo $customer->getContact(); ?></td>
                                        <td><?php echo $customer->getRegistrationDate(); ?></td>
                                        <td><?php echo $customer->getAddress(); ?></td>
                                        <td>$<?php echo $customer->getAmount(); ?></td>
                                        <td><?php echo $customer->getServices(); ?></td>
                                        <td><?php echo $customer->getPlan(); ?> Days</td>
                                        <td>
                                            <a href="memberform-edit.php?id=<?php echo $customer->getUserId(); ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<!-- JavaScript Libraries -->
<?php include 'includes/js_libraries.php'; ?>

<script type="text/javascript">
    // Function to transfer to a different page
    function goPage(newURL) {
        if (newURL !== "") {
            if (newURL === "-") {
                resetMenu();
            } else {
                document.location.href = newURL;
            }
        }
    }

    // Resets the menu selection upon entry to this page
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>

</body>
</html>
