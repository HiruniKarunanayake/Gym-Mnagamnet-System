<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
?>
 
<!DOCTYPE html>
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
  <?php $page='announcement'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a><a href="announcement.php" class="current">Announcements</a> </div>
  <h1>Announcement <i class="fa fa-bullhorn" aria-hidden="true"></i></h1>
</div>
<div class="container-fluid">
  <hr>
  <a href="announcement-manage.php"><button class="btn btn-danger" type="button">Manage Your Announcements</button></a>
  <div class="row-fluid">
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"> <i class="fa fa-th"></i> </span>
        <h5>Make Announcements</h5>
      </div>
      <div class="widget-content">
        <div class="control-group">
          <form action="announcement-post.php" method="POST">
            <div class="controls">
              <textarea class="span12" name="message" rows="6" placeholder="Enter text ..."></textarea>
            </div>
            <div class="controls">
                <h5><label for="Announce Date">Applied Date: 
              <input type="date" name="date"></h5> </label>
            </div>
            <div class="text-center">
            <button type="submit" class="btn btn-info btn-large">Publish Now</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


</div></div>


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
<script>
	$('.textarea_editor').wysihtml5();
</script>
</body>
</html>
