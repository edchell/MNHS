<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
        <link rel="stylesheet" href="student_portal.css">

    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.js"></script>
  </head>
<body>

<div class="container-fluid">
  <div class="login-form" id="login_modal" role="dialog" >
  <center><h3 style="color:black;border-radius:5px"><b>Please Enter LRN No.</b></h3></center>
  <form class="form-horizontal" action="student_view_code.php" method="post">
    <div class="form-group" id="lrn_form">
      <label id="lrn_label" class="control-label col-sm-3" for="lrn_no">LRN No:</label>
      <div class="col-md-9">
      <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
        <input type="text" class="form-control" id="lrn_no" name="lrn_no" placeholder="Enter LRN No." maxlength="12" autocomplete="off">
      </div>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-md-offset-9 col-md-12" id="buttons">
        <button class="btn btn-default" name="submit" id="submit">Submit</button>
      </div>
    </div>
  </form>
   </div>          
</div>

</body>
<script src="assets/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</html>