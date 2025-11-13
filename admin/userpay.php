<?php
session_start();
// Check if user is logged in
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
    <title>Gym System</title>
    <?php include 'includes/head.php';?>
</head>
<body>

<!--Header-part-->
<div id="header">
    <h1><a href="dashboard.php">Perfect Gym</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include 'includes/header.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page='payment'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> 
            <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
            <a href="payment.php" class="tip-bottom">Payment</a> 
            <a href="#" class="current">Make Payments</a> 
        </div>
        <h1>Payments</h1>
    </div>
    <form role="form" action="index.php" method="POST">
        <?php 
            if(isset($_POST['amount'])) { 
                try {
                    $fullName = $_POST['fullname'];
                    $paidDate = $_POST['paid_date'];
                    $services = $_POST["services"];
                    $amount = $_POST["amount"];
                    $plan = $_POST["plan"];
                    $status = $_POST["status"];
                    $userId = $_POST['id'];

                    $amountpayable = $amount * $plan;
                    $reminder = "0"; // after payment no reminders

                    date_default_timezone_set('Asia/Colombo');
                    $current_date = date('Y-m-d h:i A');
                    $exp_date_time = explode(' ', $current_date);
                    $paidDate =  $exp_date_time[0];
                    $curr_time =  $exp_date_time[1] . ' ' . $exp_date_time[2];

                    $previousResult = Customer::getCustomerByUserId($con, $userId);
                    
                    $customer = new Customer(
                        null, 
                        $fullName, 
                        $previousResult->getUsername(), 
                        $previousResult->getPassword(), 
                        $previousResult->getGender(), 
                        $previousResult->getRegistrationDate(), 
                        $services, 
                        $amountpayable, 
                        $paidDate, 
                        $previousResult->getPaidYear(), 
                        $plan, 
                        $previousResult->getAddress(),
                        $previousResult->getContact(), 
                        $status, 
                        $previousResult->getAttendanceCount(), 
                        $previousResult->getInitialWeight(), 
                        $previousResult->getCurrentWeight(), 
                        $previousResult->getInitialBodyType(), 
                        $previousResult->getCurrentBodyType(), 
                        $previousResult->getProgressDate(), 
                        $reminder
                    );

                    $result = $customer->updateCustomerPayment($con, $userId);

                    if(!$result) { ?>
                        <h3 class="text-center">Something went wrong!</h3>
                    <?php } else { 
                        if ($status == 'Active') { ?>
                            <table class="body-wrap">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td class="container" width="600">
                                            <div class="content">
                                                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="content-wrap aligncenter print-container">
                                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="content-block">
                                                                                <h3 class="text-center">Payment Receipt</h3>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="content-block">
                                                                                <table class="invoice">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div style="float:left">Invoice #GMS_<?php echo(rand(100000,10000000));?> <br> No 12, Anagarika Dharmapala Mw, <br> Matara </div>
                                                                                                <div style="float:right"> Last Payment: <?php echo $paidDate?></div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="text-center" style="font-size:14px;">
                                                                                                <b>Member: <?php echo $fullName; ?></b>  <br>
                                                                                                Paid On: <?php echo date("F j, Y - g:i a");?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td><b>Service Taken</b></td>
                                                                                                            <td class="alignright"><b>Valid Upto</b></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><?php echo $services; ?></td>
                                                                                                            <td class="alignright"><?php echo $plan?> Month/s</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><?php echo 'Charge Per Month'; ?></td>
                                                                                                            <td class="alignright"><?php echo '$'.$amount?></td>
                                                                                                        </tr>
                                                                                                        <tr class="total">
                                                                                                            <td class="alignright" width="80%">Total Amount</td>
                                                                                                            <td class="alignright">$<?php echo $amountpayable; ?></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="content-block text-center">
                                                                                We sincerely appreciate your promptness regarding all payments from your side.
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="footer">
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="aligncenter content-block">
                                                                    <button class="btn btn-danger" onclick="window.print()"><i class="icon icon-print"></i> Print</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class='error_ex'>
                                <h1>409</h1>
                                <h3>Looks like you've deactivated the customer's account!</h3>
                                <p>The selected member's account will no longer be ACTIVATED until the next payment.</p>
                                <a class='btn btn-danger btn-big' href='payment.php'>Go Back</a>
                            </div>
                        <?php } 
                    }
                } catch (Exception $e) { ?>
                    <h3 class="text-center">An error occurred: <?php echo $e->getMessage(); ?></h3>
                <?php }
            } else { ?>
                <h3>YOU ARE NOT AUTHORIZED TO REDIRECT THIS PAGE. GO BACK to <a href='index.php'> DASHBOARD </a></h3>
            <?php }
        ?>
    </form>
</div>

<!--end-main-container-part-->

<style>
body {
    -webkit-font-smoothing: antialiased;
    -webkit-text-size-adjust: none;
    width: 100% !important;
    height: 100%;
    line-height: 1.6;
}

table td {
    vertical-align: top;
}

.body-wrap {
    background-color: #f6f6f6;
    width: 100%;
}

.container {
    display: block !important;
    max-width: 600px !important;
    margin: 0 auto !important;
    clear: both !important;
}

.content {
    max-width: 600px;
    margin: 0 auto;
    display: block;
    padding: 20px;
}

.main {
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 3px;
}

.content-wrap {
    padding: 20px;
}

.footer {
    width: 100%;
    clear: both;
    color: #999;
    padding: 20px;
}

.invoice {
    margin: 22px auto;
    text-align: left;
    width: 80%;
}
.invoice td {
    padding: 7px 0;
}
.invoice .invoice-items {
    width: 100%;
}
.invoice .invoice-items td {
    border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 700;
}

@media only screen and (max-width: 640px) {
    h2 {
        font-size: 18px !important;
    }
    
    .container {
        width: 100% !important;
    }
    
    .content, .content-wrap {
        padding: 10px !important;
    }

    .invoice {
        width: 100% !important;
    }
}

@media print {
  * {
    display: none;
  }

  .print-container, .print-container * {
    visibility: visible;
  }

  .print-container {
    position: absolute;
    left: 0px;
    top: 0px;
    right: 0px;
  }
}
</style>

<!--end-Footer-part-->

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

<?php include 'includes/js_libraries.php'; ?>

<script type="text/javascript">
function goPage (newURL) {
    if (newURL != "") {
        if (newURL == "-" ) {
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
