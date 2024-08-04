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
    <style>
      body {
        display: flex;
        height: 100vh;
        width: 100vw;
        justify-content: center;
        align-items: center;
        background-image: url('images/Mad.jpg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        margin: 0;
      }
      .login-form {
        position: fixed;
        border: 2px solid grey;
        border-radius: 10px;
        padding: 30px;
        width: 500px;
        background-color: rgba(255, 255, 255, 0.8);
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
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
    <div id="fetch-feild"></div> <!-- Add this element to display AJAX results -->
    <?php if (isset($error_message)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($error_message); ?> <!-- Use htmlspecialchars to prevent XSS -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ie-emulation-modes-warning.js"></script>
<script>
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
