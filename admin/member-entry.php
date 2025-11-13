<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit;
}
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
            <a href="index.html" title="Go to Home" class="tip-bottom"><i class="fa fa-home"></i> Home</a>
            <a href="#" class="tip-bottom">Manage Members</a>
            <a href="#" class="current">Add Members</a>
        </div>
        <h1>Member Entry Form</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fa fa-align-justify"></i></span>
                        <h5>Personal Info</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="member-add-req.php" method="POST" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Full Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="fullname" placeholder="First name" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Username :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="username" placeholder="Username" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password :</label>
                                <div class="controls">
                                    <input type="password" class="span11" name="password" placeholder="**********" />
                                    <span class="help-block">Note: The given information will create an account for this particular member</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Gender :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="gender" placeholder="Male or Female" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">D.O.R :</label>
                                <div class="controls">
                                    <input type="date" name="dor" class="span11" />
                                    <span class="help-block">Date of registration</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="normal" class="control-label">Plans: </label>
                                <div class="controls">
                                    <select name="plan" required="required" id="select">
                                        <option value="30" selected="selected">One Month</option>
                                        <option value="90">Three Month</option>
                                        <option value="180">Six Month</option>
                                        <option value="365">One Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fa fa-align-justify"></i></span>
                        <h5>Contact Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label for="normal" class="control-label">Contact Number</label>
                                <div class="controls">
                                    <input type="number" id="mask-phone" name="contact" class="span8 mask text">
                                    <span class="help-block blue span8">(071) 644 5899</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="span11" name="address" placeholder="Address" />
                                </div>
                            </div>
                        </div>
                        <div class="widget-title">
                            <span class="icon"><i class="fa fa-align-justify"></i></span>
                            <h5>Service Details</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">Services</label>
                                    <div class="controls">
                                        <label>
                                            <input type="radio" value="Fitness" name="services" />
                                            Fitness
                                        </label>
                                        <label>
                                            <input type="radio" value="Sauna" name="services" />
                                            Sauna
                                        </label>
                                        <label>
                                            <input type="radio" value="Cardio" name="services" />
                                            Cardio
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Total Amount</label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <span class="add-on">$</span>
                                            <input type="number" placeholder="500" name="amount" class="span11">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-center">
                                    <button type="submit" class="btn btn-success">Submit Member Details</button>
                                </div>
                            </form>
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
