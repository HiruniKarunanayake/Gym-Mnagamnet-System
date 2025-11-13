<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
require_once '../classes/DbConnector.php';
require_once '../classes/Customer.php';
require_once '../classes/Announcement.php';

use classes\DbConnector;
use classes\Announcement;

$con = DbConnector::getConnection();
?>
 
<html lang="en">
<head>
<title>Gym System Admin</title>
<meta charset="UTF-8" />
<?php include 'includes/head.php';?>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu--> 
<?php include 'includes/topheader.php'?>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->

<!--sidebar-menu-->
<?php include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="#" class="current">Announcement</a> </div>
  <h1>Announcement</h1>
</div>
<form role="form" action="index.php" method="POST">
<?php

if(isset($_POST['message'])){
$message = $_POST["message"];    
$date = $_POST["date"];


$announcement=new Announcement(null, $message, $date);
$result = $announcement->sendAnnouncement($con);

if(!$result){
  echo"<div class='container-fluid'>";
      echo"<div class='row-fluid'>";
      echo"<div class='span12'>";
      echo"<div class='widget-box'>";
      echo"<div class='widget-title'> <span class='icon'> <i class='fas fa-info'></i> </span>";
          echo"<h5>Error Message</h5>";
          echo"</div>";
          echo"<div class='widget-content'>";
              echo"<div class='error_ex'>";
              echo"<h1 style='color:maroon;'>Error 404</h1>";
              echo"<h3>Error occured while entering your details</h3>";
              echo"<p>Please Try Again</p>";
              echo"<a class='btn btn-warning btn-big'  href='member-edit.php'>Go Back</a> </div>";
          echo"</div>";
          echo"</div>";
      echo"</div>";
      echo"</div>";
  echo"</div>";
}else {
    echo("<script>location.href = 'index.php';</script>");
}

}else{
    echo"<h3>YOU ARE NOT AUTHORIZED TO REDIRECT THIS PAGE. GO BACK to <a href='index.php'> DASHBOARD </a></h3>";
}


?>
                                    
                                
                                        
                
                                    </form>
                                </div>


<!--end-main-container-part-->

<!--Footer-part-->
<?php include 'includes/footer.php'; ?>
<!--end-Footer-part-->

<?php include 'includes/js_libraries.php'; ?>

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
