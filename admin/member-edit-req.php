<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../classes/DbConnector.php';
require_once '../classes/Customer.php';

use classes\DbConnector;
use classes\Customer;

// Get database connection
$con = DbConnector::getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System</title>
    <?php include 'includes/head.php'; ?>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            <a href="index.html" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="tip-bottom">Manage Members</a>
            <a href="#" class="current">Add Members</a>
        </div>
        <h1>Update Member Details</h1>
    </div>

    <form role="form" action="index.php" method="POST">
        <?php
        if (isset($_POST['fullname'])) {
            $fullName = $_POST["fullname"];
            $username = $_POST["username"];
            $registrationDate = $_POST["dor"];
            $gender = $_POST["gender"];
            $services = $_POST["services"];
            $amount = $_POST["amount"];
            $plan = $_POST["plan"];
            $address = $_POST["address"];
            $contact = $_POST["contact"];
            $userId = $_POST["id"];

            // Fetch previous customer data
            $previousResult = Customer::getCustomerByUserId($con, $userId);
            if ($previousResult) {
                $customer = new Customer(
                    null, $fullName, $username, $previousResult->getPassword(), $gender, $registrationDate,
                    $services, $amount, $previousResult->getPaidDate(), $previousResult->getPaidYear(), $plan,
                    $address, $contact, $previousResult->getStatus(), $previousResult->getAttendanceCount(),
                    $previousResult->getInitialWeight(), $previousResult->getCurrentWeight(),
                    $previousResult->getInitialBodyType(), $previousResult->getCurrentBodyType(),
                    $previousResult->getProgressDate(), $previousResult->getReminder()
                );

                $result = $customer->updateCustomer($con, $userId);

                if ($result) {
                    echo "<div class='container-fluid'>
                            <div class='row-fluid'>
                                <div class='span12'>
                                    <div class='widget-box'>
                                        <div class='widget-title'>
                                            <span class='icon'><i class='fas fa-info-circle'></i></span>
                                            <h5>Message</h5>
                                        </div>
                                        <div class='widget-content'>
                                            <div class='error_ex'>
                                                <h1>Success</h1>
                                                <h3>Member details have been updated!</h3>
                                                <p>The requested details are updated. Please click the button to go back.</p>
                                                <a class='btn btn-inverse btn-big' href='members.php'>Go Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
                } else {
                    echo "<div class='container-fluid'>
                            <div class='row-fluid'>
                                <div class='span12'>
                                    <div class='widget-box'>
                                        <div class='widget-title'>
                                            <span class='icon'><i class='fas fa-info-circle'></i></span>
                                            <h5>Error Message</h5>
                                        </div>
                                        <div class='widget-content'>
                                            <div class='error_ex'>
                                                <h1 style='color:maroon;'>Error 404</h1>
                                                <h3>Error occurred while updating your details</h3>
                                                <p>Please Try Again</p>
                                                <a class='btn btn-warning btn-big' href='member-edit.php'>Go Back</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }
            } else {
                echo "<h3>User not found. Please go back to the <a href='index.php'>dashboard</a>.</h3>";
            }
        } else {
            echo "<h3>You are not authorized to redirect this page. Go back to the <a href='index.php'>dashboard</a>.</h3>";
        }
        ?>
    </form>
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
