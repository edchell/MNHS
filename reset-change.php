<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/logo.jpg">

    <title>Student Grading System</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
        <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.js"></script>
    <style>
      body{
        display: flex;
        height: calc(100%);
        width: calc(100%);
        justify-content: center;
        align-items: center;
        background:url('images/bg.jpg');
        background-repeat: no-repeat;
        background-size: 1400px 800px;
      }
      .login-form {
  display: block;
  position: fixed;
  border:5px solid grey;
  border-radius: 20px;
  padding: 30px;
  width: 500px;
  background-color: transparent;
  left:450px;
  top:100px;
  color: black;
 } 
 .erlert{
  display:block;
  border-radius:5px;
  background-color:rgba(230, 103, 42, 0.37);
  padding: 5px;
}
    </style>
  </head>
<body>
  

<div class="container-fluid">

  <div class="login-form" id="login_modal" role="dialog" >


  <center><h3 style="color:black;border-radius:5px"><b>Send Reset Password</b></h3></center>
  
  

  <form class="form-horizontal" method="post">
  <div class="form-group">
      <div class="col-md-10">
      <div class="input-group">
        <?php
        include 'db.php';
        $token = $_GET['token'];

        $token_query = "SELECT * FROM user WHERE TOKEN = ? AND TOKEN_USED = 0";
        $stmt = mysqli_prepare($conn, $token_query);
        mysqli_stmt_bind_param($stmt, 's', $token);
        mysqli_stmt_execute($stmt);
        $token_result = mysqli_stmt_get_result($stmt);

        if($token_result) {
            if(mysqli_num_rows($token_result) > 0) {
                $user = mysqli_fetch_assoc($token_result);
        ?>
        <input type="hidden" class="form-control" name="email" value="<?php echo $user['USER'] ?>" autocomplete="off">
        <?php
            }
        }
        ?>
      </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="new_password">New Password:</label>
      <div class="col-md-10">
      <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-lock fa" aria-hidden="true"></i></span>
        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password" autocomplete="off">
      </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="con_password">Confirm Password:</label>
      <div class="col-md-10">
      <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-lock fa" aria-hidden="true"></i></span>
        <input type="password" class="form-control" id="con_password" name="con_password" placeholder="Enter Confirm Password" autocomplete="off">
      </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-10">
      <div class="input-group" style="font-weight:bold;">
      <input type="checkbox" style="margin-left:80px;margin-top:-20px;" id="togglePassword">&nbspShow Password
      </div>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-md-offset-6 col-md-12">
      <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Create New</button>-->
        <button type="hidden" name="change" class="btn btn-default">Change</button>
        <a href="login.php" class="btn btn-primary">Back to Login</a>       
      </div>
    </div>
  </form>
   <?php
  include 'reset-submit.php';
  ?>
   </div>          
</div>


    <script src="assets/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  
    <script>
        const togglePassword = document.getElementById('togglePassword');
    const newPasswordInput = document.getElementById('new_password');
    const conPasswordInput = document.getElementById('con_password');

    togglePassword.addEventListener('change', () => {
        const type = togglePassword.checked ? 'text' : 'password';
        newPasswordInput.setAttribute('type', type);
        conPasswordInput.setAttribute('type', type);
    });
    </script>
</html>
