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
  background-color:rgba(230, 42, 42, 1);
  padding: 5px;
}
    </style>
  </head>
<body>
  

<div class="container-fluid">

  <div class="login-form" id="login_modal" role="dialog" >


  <center><h3 style="color:black;border-radius:5px"><b>Please Login</b></h3></center>
  
  

  <form class="form-horizontal" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2" for="user">Email:</label>
      <div class="col-md-10">
      <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
        <input type="email" class="form-control" id="user" name="user" placeholder="Enter Email" autocomplete="off">
      </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-md-10">
      <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key fa" aria-hidden="true"></i></span>
          
        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password">
      </div>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-md-offset-6 col-md-12">
      <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Create New</button>-->
        <button type="hidden"  class="btn btn-default">Login</button>       
        <a href="reset-password.php" class="text-decoration-none btn btn-primary">Forgot password?</a>
      </div>
    </div>
  </form>
   <?php
  include 'connect.php';
  ?>
   </div>          
</div>


    <script src="assets/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  
</html>
