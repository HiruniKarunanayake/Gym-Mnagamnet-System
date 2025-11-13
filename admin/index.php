<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
}

require_once '../classes/DbConnector.php';
require_once '../classes/Todo.php';
require_once '../classes/Announcement.php';
require_once '../classes/Customer.php';
require_once '../classes/Staff.php';
require_once '../classes/Equipment.php';
require_once '../classes/Attendance.php';

use classes\DbConnector;
use classes\Todo;
use classes\Announcement;
use classes\Customer;
use classes\Staff;
use classes\Equipment;
use classes\Attendance;

$con = DbConnector::getConnection();

// Queries for charts
$qry_services = "SELECT services, count(*) as number FROM members GROUP BY services";
$result_services = $con->query($qry_services);

$qry_gender = "SELECT gender, count(*) as enumber FROM members GROUP BY gender";
$result_gender = $con->query($qry_gender);

$qry_designation = "SELECT designation, count(*) as snumber FROM staffs GROUP BY designation";
$result_designation = $con->query($qry_designation);

$qry_earnings = "SELECT SUM(amount) as earnings FROM members";
$result_earnings = $con->query($qry_earnings);
$earnings = $result_earnings->fetch(PDO::FETCH_ASSOC);

$qry_expenses = "SELECT SUM(amount) as expenses FROM equipment";
$result_expenses = $con->query($qry_expenses);
$expenses = $result_expenses->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin</title>
    <?php include("includes/head.php"); ?> <!-- include head -->

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // Draw Gender Distribution Pie Chart
            var genderData = google.visualization.arrayToDataTable([
                ['Gender', 'Number'],
                <?php while($row = $result_gender->fetch(PDO::FETCH_ASSOC)) { ?>
                    ['<?php echo $row["gender"]; ?>', <?php echo $row["enumber"]; ?>],
                <?php } ?>
            ]);
            var genderOptions = {
                pieHole: 0.4
            };
            var genderChart = new google.visualization.PieChart(document.getElementById('donutchart'));
            genderChart.draw(genderData, genderOptions);

            // Draw Staff Distribution Donut Chart
            var staffData = google.visualization.arrayToDataTable([
                ['Designation', 'Number'],
                <?php while($row = $result_designation->fetch(PDO::FETCH_ASSOC)) { ?>
                    ['<?php echo $row["designation"]; ?>', <?php echo $row["snumber"]; ?>],
                <?php } ?>
            ]);
            var staffOptions = {
                pieHole: 0.4
            };
            var staffChart = new google.visualization.PieChart(document.getElementById('donutchart2022'));
            staffChart.draw(staffData, staffOptions);

            // Draw Services Bar Chart
            var servicesData = google.visualization.arrayToDataTable([
                ['Services', 'Total Numbers'],
                <?php while($row = $result_services->fetch(PDO::FETCH_ASSOC)) { ?>
                    ['<?php echo $row["services"]; ?>', <?php echo $row["number"]; ?>],
                <?php } ?>
            ]);
            var servicesOptions = {
                bars: 'vertical',
                axes: {
                    x: {
                        0: { side: 'top', label: 'Total' }
                    }
                },
                bar: { groupWidth: "100%" }
            };
            var servicesChart = new google.charts.Bar(document.getElementById('top_x_div'));
            servicesChart.draw(servicesData, servicesOptions);

            // Draw Earnings and Expenses Bar Chart
            var earningsExpensesData = google.visualization.arrayToDataTable([
                ['', 'Amount'],
                ['Earnings', <?php echo $earnings["earnings"]; ?>],
                ['Expenses', <?php echo $expenses["expenses"]; ?>]
            ]);
            var earningsExpensesOptions = {
                width: "100%",
                height: 220,
                legend: { position: 'none' },
                bars: 'horizontal',
                axes: {
                    x: {
                        0: { side: 'top', label: 'Total' }
                    }
                },
                bar: { groupWidth: "100%" }
            };
            var earningsExpensesChart = new google.charts.Bar(document.getElementById('earnings_expenses_div'));
            earningsExpensesChart.draw(earningsExpensesData, earningsExpensesOptions);
        }
    </script>
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
<?php $page = 'dashboard'; include 'includes/sidebar.php'; ?>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="You're right here" class="tip-bottom"><i class="fa fa-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
          <li class="bg_ls span"> <a href="index.php" style="font-size: 16px;"> <i class="fas fa-user-check"></i> <span class="label label-important"><?php echo Customer::getActiveCustomerCount($con)?></span> Active Members </a> </li>
        <li class="bg_lo span3"> <a href="members.php" style="font-size: 16px;"> <i class="fas fa-users"></i></i><span class="label label-important"><?php echo Customer::getCustomerCount($con)?></span> Registered Members</a> </li>
        <li class="bg_lg span3"> <a href="payment.php" style="font-size: 16px;"> <i class="fa fa-dollar-sign"></i> Total Earnings: $<?php echo Customer::getIncomeCount($con) ?></a> </li>
        <li class="bg_lb span2"> <a href="announcement.php" style="font-size: 16px;"> <i class="fas fa-bullhorn"></i><span class="label label-important"><?php echo Announcement::getAnnouncementCount($con)?></span>Announcements </a> </li>

        
        <!-- <li class="bg_ls span2"> <a href="buttons.html"> <i class="fas fa-tint"></i> Buttons</a> </li>
        <li class="bg_ly span3"> <a href="form-common.html"> <i class="fas fa-th-list"></i> Forms</a> </li>
        <li class="bg_lb span2"> <a href="interface.html"> <i class="fas fa-pencil"></i>Elements</a> </li> -->
        <!-- <li class="bg_lg"> <a href="calendar.html"> <i class="fas fa-calendar"></i> Calendar</a> </li>
        <li class="bg_lr"> <a href="error404.html"> <i class="fas fa-info-sign"></i> Error</a> </li> -->
 
      </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="fas fa-file"></i></span>
          <h5>Services Report</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span8">
              <!-- <div id="piechart"></div>   -->
              <div id="top_x_div" style="width: 700px; height: 290px;"></div>
            </div>
            <div class="span4">
              <ul class="site-stats">
                  <li class="bg_lh"><i class="fas fa-users"></i> <strong><?php echo Customer::getCustomerCount($con);?></strong> <small>Total Members</small></li>
                  <li class="bg_lg"><i class="fas fa-user-clock"></i> <strong><?php echo Staff::getStaffCount($con);?></strong> <small>Staff Users</small></li>
                  <li class="bg_ls"><i class="fas fa-dumbbell"></i> <strong><?php echo Equipment::getEquipmentCount($con);?></strong> <small>Available Equipments</small></li>
                  <li class="bg_ly"><i class="fas fa-file-invoice-dollar"></i> <strong>$<?php echo Equipment::getTotalExpense($con);?></strong> <small>Total Expenses</small></li>
                <li class="bg_lr"><i class="fas fa-user-ninja"></i> <strong><?php echo Staff::getTrainerCount($con);?></strong> <small>Active Gym Trainers</small></li>
                <li class="bg_lb"><i class="fas fa-calendar-check"></i> <strong><?php echo Attendance::getAttendanceCount($con);?></strong> <small>Present Members</small></li>
              </ul>
            </div>
          </div>
        </div>
      </div> 
    </div><!-- End of row-fluid -->

    <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title bg_lg"><span class="icon"><i class="fas fa-file"></i></span>
                    <h5>Earnings & Expenses Reports</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">
                            <div id="earnings_expenses_div" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End of row-fluid -->

    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="fas fa-chevron-down"></i></span>
            <h5>Registered Gym Members by Gender: Overview</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
              
              <div id="donutchart" style="width: 600px; height: 300px;"></div>

            </ul>
          </div>
        </div>
      </div>

      <div class="span6">
        <div class="widget-box">
          <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="fas fa-chevron-down"></i></span>
            <h5>Staff Members by Designation: Overview</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
              
            <div id="donutchart2022" style="width: 600px; height: 300px;"></div>
            </ul>
          </div>
        </div>   
      </div>
      </div>
	
<!--End-Chart-box-->  
    <!-- <hr/> -->
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="fas fa-chevron-down"></i></span>
            <h5>Gym Announcement</h5>
          </div>
          <div class="widget-content nopadding collapse in" id="collapseG2">
            <ul class="recent-posts">
              <li>

              <?php
                $announcementList= Announcement::manageAnnouncement($con);

                foreach ($announcementList as $announcement):
                  echo"<div class='user-thumb'> <img width='70' height='40' alt='User' src='../img/demo/av1.jpg'> </div>";
                  echo"<div class='article-post'>"; 
                  echo"<span class='user-info'> By: System Administrator / Date: ".$announcement->getDate()." </span>";
                  echo"<p><a href='#'>".$announcement->getMessage()."</a> </p>";
                 
                  endforeach;

                echo"</div>";
                echo"</li>";
              ?>

              <a href="announcement-manage.php"><button class="btn btn-warning btn-mini">View All</button></a>
              </li>
            </ul>
          </div>
        </div> 
       
         
      </div>
      <div class="span6">
       
      <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="fas fa-tasks"></i></span>
            <h5>Customer's To-Do Lists</h5>
          </div>
          <div class="widget-content">
            <div class="todo">
              <ul>
              <?php

                
                $result= Todo::getAllTodo($con);

                foreach ($result as $todo): ?>

                <li class='clearfix'> 
                                                                        
                    <div class='txt'> <?php echo $todo->getTaskDescription()?> <?php if ($todo->getTaskStatus() == "Pending") { echo '<span class="by label label-info">Pending</span>';} else { echo '<span class="by label label-success">In Progress</span>'; }?></div>
                
               <?php 
                endforeach;
             
                echo"</li>";
              echo"</ul>";
              ?>
            </div>
          </div>
        </div>
       
                </div>
       
      </div> <!-- End of ToDo List Bar -->
    </div><!-- End of Announcement Bar -->
  </div><!-- End of container-fluid -->
</div><!-- End of content-ID -->

<!--end-main-container-part-->

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> <?php include 'includes/footer.php'; ?> </div>
</div>
<!--end-Footer-part-->

<!--add js_libraries-->
<?php include("includes/js_libraries.php"); ?>
<!--end-add js_libraries-->

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
