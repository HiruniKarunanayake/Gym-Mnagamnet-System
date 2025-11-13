<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:../index.php');
    exit; // Ensure script stops here if not logged in
}

require_once '../classes/DbConnector.php';

use classes\DbConnector;

$con = DbConnector::getConnection();

// Query for gender distribution of members
$qry_gender = "SELECT gender, count(*) as number FROM members GROUP BY gender";
$result_gender = $con->query($qry_gender);

// Query for earnings from members
$qry_earnings = "SELECT 'Earnings' as term, SUM(amount) as total_amount FROM members";
$result_earnings = $con->query($qry_earnings);
$earnings_data = $result_earnings->fetch(PDO::FETCH_ASSOC);

// Query for expenses on equipment
$qry_expenses = "SELECT 'Expenses' as term, SUM(amount) as total_amount FROM equipment";
$result_expenses = $con->query($qry_expenses);
$expenses_data = $result_expenses->fetch(PDO::FETCH_ASSOC);

// Query for services usage report
$qry_services = "SELECT services, count(*) as number FROM members GROUP BY services";
$result_services = $con->query($qry_services);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin</title>
    <?php include 'includes/head.php'; ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
    <script type="text/javascript">  
        google.charts.load('current', {'packages':['corechart', 'bar']});  
        google.charts.setOnLoadCallback(drawCharts);  

        function drawCharts() {  
            // Gender Distribution Pie Chart
            var genderData = google.visualization.arrayToDataTable([
                ['Gender', 'Number'],
                <?php  
                while($row = $result_gender->fetch(PDO::FETCH_ASSOC)) {  
                    echo "['".$row["gender"]."', ".$row["number"]."],";  
                }  
                ?>
            ]);  
            var genderOptions = {  
                title: 'Percentage of Male and Female GYM Members',  
                pieHole: 0.0 
            };  
            var genderChart = new google.visualization.PieChart(document.getElementById('piechart'));  
            genderChart.draw(genderData, genderOptions);  

            // Earnings and Expenses Bar Chart
            var earningsExpensesData = google.visualization.arrayToDataTable([
                ['Terms', 'Amount'],
                ['Earnings', <?php echo $earnings_data['total_amount']; ?>],
                ['Expenses', <?php echo $expenses_data['total_amount']; ?>]
            ]);
            var earningsExpensesOptions = {
                width: 1000, // Adjusted width to match other charts
                legend: { position: 'none' },
                bars: 'horizontal',
                axes: {
                    x: { side: 'top', label: 'Total' }
                },
                bar: { groupWidth: "100%" }
            };
            var earningsExpensesChart = new google.charts.Bar(document.getElementById('bar_chart_div'));
            earningsExpensesChart.draw(earningsExpensesData, earningsExpensesOptions);

            // Services Bar Chart
            var servicesData = google.visualization.arrayToDataTable([
                ['Services', 'Total Numbers'],
                <?php  
                while($row = $result_services->fetch(PDO::FETCH_ASSOC)) {  
                    echo "['".$row["services"]."', ".$row["number"]."],";  
                }  
                ?>
            ]);
            var servicesOptions = {
                width: 1000,
                legend: { position: 'none' },
                bars: 'horizontal',
                axes: {
                    x: { side: 'top', label: 'Total' }
                },
                bar: { groupWidth: "100%" }
            };
            var servicesChart = new google.charts.Bar(document.getElementById('services_chart_div'));
            servicesChart.draw(servicesData, servicesOptions);
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
    <?php $page='chart'; include 'includes/sidebar.php'; ?>
    <!--sidebar-menu-->

    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> 
                <a href="index.php" title="Go to Home" class="tip-bottom">
                    <i class="fas fa-home"></i> Home
                </a> 
                <a href="reports.php" class="current">Chart Representation</a> 
            </div>
            <h1 class="text-center">Earnings and Expenses Report <i class="fas fa-chart-bar"></i></h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div id="bar_chart_div" style="width: 1000px; height: 300px;"></div> <!-- Adjusted width here -->
                </div>
            </div>
        </div>

        <div id="content-header">
            <h1 class="text-center">Registered Member's Report <i class="fas fa-chart-bar"></i></h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div id="piechart" style="width: 800px; height: 450px; margin: 0 auto;"></div>  
                </div>
            </div>
        </div>

        <div id="content-header">
            <h1 class="text-center">Services Report <i class="fas fa-chart-bar"></i></h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div id="services_chart_div" style="width: 1000px; height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!--end-main-container-part-->
    <!--Footer-part-->
    <?php include 'includes/footer.php'; ?>
    <!--end-Footer-part-->
    <?php include 'includes/js_libraries.php'; ?>
</body>
</html>
