
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
   
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
        background-image: url('images/Mad.jpg.jpg');
        background-repeat: no-repeat; /* Prevent tiling */
        background-size: contain; /* Scale the image to fit within the container */
        background-position: center; /* Center the image */
        width: 50%; /* Set the width of the container */
        height: 600px; 
      }
      .login-form {
  display: block;
  position: fixed;
  border:2px solid grey;
  border-radius: 10px;
  padding: 30px;
  width: 500px;
  background-color: transparent;
  left:500px;
  top:110px;
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


  

  <form class="form-horizontal" id="loginForm" method="post">
    <div class="form-group">
      <center>  <label class="control-label col-sm-2" for="user">User:</label> </center>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="user" name="user" placeholder="Enter User" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="form-group">
    <center>   <label class="control-label col-sm-2" for="pwd">Password:</label> </center>
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key fa" aria-hidden="true"></i></span>
                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="form-group">        
        <div class="col-md-offset-6 col-md-9">
          <button type="submit" class="btn btn-default">Login</button>
          <a href="view2.php" class="btn btn-primary">Student View</a> 
        </div>
    </div>
</form>

  <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
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
