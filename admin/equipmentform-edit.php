<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
}

require_once '../classes/DbConnector.php';
require_once '../classes/Equipment.php';

use classes\DbConnector;
use classes\Equipment;

$con = DbConnector::getConnection();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gym System Staff A/C</title>
        <?php include 'includes/head.php' ?>
    </head>
    <body>

        <!--Header-part-->
        <div id="header">
            <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
        </div>
        <!--close-Header-part--> 

        <!--top-Header-menu-->
        <?php include 'includes/header.php' ?>
        <!--close-top-Header-menu-->
        <!--sidebar-menu-->
        <?php $page = "equipment";
        include 'includes/sidebar.php' ?>
        <!--sidebar-menu-->

        <?php
        $id = $_GET['id'];
        $equipment = Equipment::getEquipmentById($con, $id);
        ?> 

        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Equipments</a> <a href="#" class="current">Edit Equipments</a> </div>
                <h1>Equipment Entry Form</h1>
            </div>
            <div class="container-fluid">
                <hr>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                <h5>Equipment-info</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <form action="equipment-edit-req.php" method="POST" class="form-horizontal">
                                    <div class="control-group">
                                        <label class="control-label">Equipment Name :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" name="name" value='<?php echo $equipment->getName(); ?>' required />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Description :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" name="description" value='<?php echo $equipment->getDescription(); ?>' required />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date of Purchase :</label>
                                        <div class="controls">
                                            <input type="date" name="date" value='<?php echo $equipment->getDate(); ?>' class="span11" />
                                            <span class="help-block">Please mention the date of purchase</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Quantity :</label>
                                        <div class="controls">
                                            <input type="number" class="span4" name="quantity" value='<?php echo $equipment->getQuantity(); ?>' required />
                                        </div>
                                    </div>
                                    <div class="widget-content nopadding">
                                        <div class="form-horizontal"></div>
                                        <div class="widget-content nopadding">
                                            <div class="form-horizontal"></div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="widget-box">
                            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                <h5>Other Details</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <div class="form-horizontal">
                                    <div class="control-group">
                                        <label for="normal" class="control-label">Contact Number</label>
                                        <div class="controls">
                                            <input type="text" id="mask-phone" name="contact" minlength="10" maxlength="10" value='<?php echo $equipment->getContact(); ?>' class="span8 mask text" required>
                                            <span class="help-block blue span8">(071 258 4879)</span> 
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Vendor :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" name="vendor" value='<?php echo $equipment->getVendor(); ?>' required />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Address :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" name="address" value='<?php echo $equipment->getAddress(); ?>' required />
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                                    <h5>Pricing</h5>
                                </div>
                                <div class="widget-content nopadding">
                                    <div class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label">Total Cost: </label>
                                            <div class="controls">
                                                <div class="input-append">
                                                    <span class="add-on">$</span> 
                                                    <input type="number" placeholder="120000" name="amount" value='<?php echo $equipment->getAmount(); ?>' class="span11" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions text-center">
                                            <!-- user's ID is hidden here -->
                                            <input type="hidden" name="id" value="<?php echo $equipment->getId(); ?>">
                                            <button type="submit" class="btn btn-success">Submit Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
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
