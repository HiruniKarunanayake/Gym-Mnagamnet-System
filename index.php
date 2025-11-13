<?php session_start();
$message = null;
if (isset($_GET["status"])) {
    $status = $_GET["status"];

    switch ($status) {
        case 0:
            $message = "<h6 class='text-danger'>Required values were not submitted</h6>";
            break;
        case 1:
            $message = "<div class='alert alert-danger alert-dismissible' role='alert'>
                Invalid Username and Password
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
            break;
        default:
            $message = "<h6 class='text-danger'>Error occurred during the login. Please try again</h6>";
            break;
    }
}
 
 
 ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
<title>Gym System Admin</title><meta charset="UTF-8" />
<?php include 'include/head.php';?>
</head>
    
    <body>
    
        <div id="loginbox">            
            <form id="loginform" method="POST" class="form-vertical" action="controllers/authenticate.php">
            <div class="control-group normal_text"> <h3><img src="img/icontest3.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="fas fa-user-circle"></i></span><input type="text" name="username" placeholder="Username" required/>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="fas fa-lock"></i></span><input type="password" name="password" placeholder="Password" required />
                        </div>
                    </div>
                </div>
                <div class="form-actions center">
                    <!-- <span class="pull-right"><a type="submit" href="index.html" class="btn btn-success" /> Login</a></span> -->
                    <!-- <input type="submit" class="button" title="Log In" name="login" value="Admin Login"></input> -->
                    <button type="submit" class="btn btn-block btn-large btn-info" title="Log In" name="login" value="Admin Login">Admin Login</button>
                </div>
            </form>
            
            <?= $message ?>
            
  
            <div class="pull-left">
            <a href="customer/index.php"><h6>Customer Login</h6></a>
            </div>

            <div class="pull-right">
            <a href="staff/index.php"><h6>Staff Login</h6></a>
            </div>
            
        </div>
        
        <script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 
        <script src="js/bootstrap.min.js"></script> 
        <script src="js/matrix.js"></script>
    </body>
 
</html>
