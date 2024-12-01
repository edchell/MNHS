<?php
$request = $_SERVER['REQUEST_URI'];

if (strpos($request, '.php') !== false) {
    // Redirect to remove .php extension
    $new_url = str_replace('.php', '', $request);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Student Grading System">
    <meta name="author" content="Your Name">
    <link rel="icon" href="images/logo.jpg">

    <title>Student Grading System</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background: url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .login-form {
            background-color: rgba(255, 255, 255, 0.9);
            border: 2px solid grey;
            border-radius: 20px;
            padding: 30px;
            width: 400px;
            margin-right: 150px; /* Add space from the right edge */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .error-message {
            display: none;
            border-radius: 5px;
            background-color: #e62a2a;
            padding: 10px;
            color: white;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-form" id="login_modal" role="dialog">
        <center><h3><b>Send Reset Password</b></h3></center>
        <form class="form-horizontal" method="post" action="reset-submit.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="login" name="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
            <div class="form-group text-center">
                <a href="." class="btn btn-default">Back to login</a>
            </div>
        </form>
    </div>

<script src="assets/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
<!-- Include SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).on('submit', 'form[action="reset-submit.php"]', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = $(this).serialize(); // Gather form data

    $.post('reset-submit.php', formData, function (response) {
        Swal.fire({
            icon: 'success',
            title: 'We email you the reset password link.',
            text: response,
            confirmButtonText: 'OK'
        }).then(() => {
            $('#login_modal').modal('hide'); // Close the modal after success
            location.href = 'reset-password.php'; // Redirect to the login page or desired location
        });
    }).fail(function (xhr, status, error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `An error occurred: ${xhr.responseText || error}`,
            confirmButtonText: 'OK'
        });
    });
});
</script>
</body>
</html>
