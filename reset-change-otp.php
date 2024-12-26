<?php
session_start();

$request = $_SERVER['REQUEST_URI'];

if (strpos($request, '.php') !== false) {
    // Redirect to remove .php extension
    $new_url = str_replace('.php', '', $request);
    header("Location: $new_url", true, 301);
    exit();
}

// Check if the email is stored in the session (after OTP verification)
if (!isset($_SESSION['email_for_reset'])) {
    header("Location: reset-password-otp.php"); // Redirect if the user didn't verify OTP
    exit(0);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css">

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
        .back {
            margin-top: -18px;
            margin-left: -15px;
        }
    </style>
</head>
<body>
<div class="login-form" id="login_modal" role="dialog">
        <div class="text-start back">
            <a href="reset-pass-choose.php" class="btn btn-primary">Back</a>
        </div>
        <center><h3><b>Change Your Password</b></h3></center>
        <?php if (isset($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo $_SESSION['status_code']; ?>" role="alert">
                <?php
                echo $_SESSION['status']; // Display the status message
                unset($_SESSION['status']); // Clear status message after displaying it
                ?>
            </div>
        <?php endif; ?>
        <form class="form-horizontal" method="POST" action="reset-submit-otp.php" id="reset-password-form">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter New Password" required>
                    <span class="input-group-addon toggle-password" style="cursor: pointer;">
                      <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                    <span class="input-group-addon toggle-password" style="cursor: pointer;">
                      <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" name="submit_password" class="btn btn-primary btn-block">Change Password</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordIcons = document.querySelectorAll('.toggle-password');

            togglePasswordIcons.forEach(function (toggleIcon) {
                toggleIcon.addEventListener('click', function () {
                    const passwordField = this.previousElementSibling; // Get the input field
                    const isPassword = passwordField.type === 'password';
                    passwordField.type = isPassword ? 'text' : 'password';

                    // Toggle the eye icon
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            });
        });

        // Form validation for password strength
        document.getElementById('reset-password-form').addEventListener('submit', function (event) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value; // Fixed the ID here

            // Password pattern to check
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordPattern.test(newPassword)) {
                // Show SweetAlert if password does not match the pattern
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Password',
                    text: 'Password must contain at least 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.',
                    confirmButtonText: 'OK'
                });
                event.preventDefault(); // Prevent form submission
            } else if (newPassword !== confirmPassword) {
                // Check if the password and confirm password fields match
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords do not match',
                    text: 'The passwords you entered do not match. Please try again.',
                    confirmButtonText: 'OK'
                });
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>
