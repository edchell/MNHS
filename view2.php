<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/Mad.jpg.jpg">

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
      body {
        display: flex;
        height: calc(100%);
        width: calc(100%);
        justify-content: center;
        align-items: center;
        background-image: url('images/Mad.jpg.jpg');
        background-repeat: no-repeat; /* Prevent tiling */
        background-size: cover; /* Scale the image to cover the container */
        background-position: center; /* Center the image */
        width: 100%; /* Set the width of the container */
        height: 100vh; /* Use full viewport height */
        margin: 0; /* Remove default margin */
      }
      .login-form {
        display: block;
        position: fixed;
        border: 2px solid grey;
        border-radius: 10px;
        padding: 30px;
        width: 500px;
        background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%); /* Center the form */
      }
      .alert {
        margin-top: 20px;
      }
    </style>
</head>
<body>
  
<div class="container-fluid">

  <div class="login-form" id="login_modal" role="dialog">
  <form id="student-search-form">
    <div class="form-group">
        <label for="lrn-no">LRN Number:</label>
        <input type="text" id="lrn-no" class="form-control" placeholder="Enter LRN Number">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" class="form-control" placeholder="Enter Last Name">
    </div>
    <button type="button" id="search-student" class="btn btn-primary">Search</button>
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
    include 'connect2.php';
    ?>
  </div>          
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#search-student').on('click', function() {
        var lrnNo = $('#lrn-no').val();
        var lastname = $('#lastname').val();

        // Perform AJAX request to search for student
        $.ajax({
            type: 'POST',
            url: 'connect2.php',
            data: {
                lrn_no: lrnNo,
                lastname: lastname
            },
            beforeSend: function() {
                $("#fetch-feild").html('Searching, please wait...');
            },
            success: function(response) {
                $("#fetch-feild").html(response);
            },
            error: function() {
                $("#fetch-feild").html('An error occurred while searching.');
            }
        });
    });
});
</script>


</body>
</html>
