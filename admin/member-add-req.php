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

$con= DbConnector::getConnection();
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

        <!--Header-part-->
        <div id="header">
            <h1><a href="dashboard.html">Perfect Gym</a></h1>
        </div>
        <!--close-Header-part--> 


        <!--top-Header-menu-->
        <?php include 'includes/header.php' ?>
        <!--close-top-Header-menu-->
        <!--start-top-serch-->
        <!-- <div id="search">
          <input type="hidden" placeholder="Search here..."/>
          <button type="submit" class="tip-bottom" title="Search"><i class="fas fa-search"></i></button>
        </div> -->
        <!--close-top-serch-->
        <!--sidebar-menu-->

        <?php $page = "member";
        include 'includes/sidebar.php' ?>

        <!--sidebar-menu-->
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="#" class="tip-bottom">Manage Members</a> <a href="#" class="current">Add Members</a> </div>
                <h1>Member Entry Form</h1>
            </div>
            <form role="form" action="index.php" method="POST">
                <?php
                if (isset($_POST['fullname'])) {
                    $fullName = $_POST["fullname"];
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $dor = $_POST["dor"];
                    $gender = $_POST["gender"];
                    $services = $_POST["services"];
                    $amount = $_POST["amount"];
                    $plan = $_POST["plan"];
                    $address = $_POST["address"];
                    $contact = $_POST["contact"];
                    $registrationDate = date("y-m-d");
                    $status = "Active";
                    
                    $customer = new Customer(null, $fullName, $username, $password, $gender, $registrationDate, $services, $amount, null, null, $plan, $address, $contact, $status, null, null, null, null, null, null, null);
                    $result = $customer->register($con);

                    if (!$result) {
                        echo "<div class='container-fluid'>";
                        echo "<div class='row-fluid'>";
                        echo "<div class='span12'>";
                        echo "<div class='widget-box'>";
                        echo "<div class='widget-title'> <span class='icon'> <i class='fas fa-info-circle'></i> </span>";
                        echo "<h5>Error Message</h5>";
                        echo "</div>";
                        echo "<div class='widget-content'>";
                        echo "<div class='error_ex'>";
                        echo "<h1 style='color:maroon;'>Error 404</h1>";
                        echo "<h3>Error occurred while entering your details</h3>";
                        echo "<p>Please Try Again</p>";
                        echo "<a class='btn btn-warning btn-big' href='member-edit.php'>Go Back</a> </div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<div class='container-fluid'>";
                        echo "<div class='row-fluid'>";
                        echo "<div class='span12'>";
                        echo "<div class='widget-box'>";
                        echo "<div class='widget-title'> <span class='icon'> <i class='fas fa-info-circle'></i> </span>";
                        echo "<h5>Message</h5>";
                        echo "</div>";
                        echo "<div class='widget-content'>";
                        echo "<div class='error_ex'>";
                        echo "<h1>Success</h1>";
                        echo "<h3>Member details have been added!</h3>";
                        echo "<p>The requested details are added. Please click the button to go back.</p>";
                        echo "<a class='btn btn-inverse btn-big' href='members.php'>Go Back</a> </div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<h3>YOU ARE NOT AUTHORIZED TO REDIRECT THIS PAGE. GO BACK to <a href='index.php'> DASHBOARD </a></h3>";
                }
                ?>
            </form>
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
    function goPage(newURL) {
        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {
            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
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
