<?php
$request = $_SERVER['REQUEST_URI'];

if (strpos($request, '.php') !== false) {
    // Redirect to remove .php extension
    $new_url = str_replace('.php', '', $request);
    header("Location: $new_url", true, 301);
    exit();
}

include 'db.php';

$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);
if (!$token) {
    http_response_code(404);
    exit; 
}

$token_query = "SELECT * FROM user WHERE TOKEN = ? AND TOKEN_USED = 0";
$stmt = mysqli_prepare($conn, $token_query);
mysqli_stmt_bind_param($stmt, 's', $token);
mysqli_stmt_execute($stmt);
$token_result = mysqli_stmt_get_result($stmt);

if (!$token_result || mysqli_num_rows($token_result) === 0) {
    die("Invalid or expired token.");
}

$user = mysqli_fetch_assoc($token_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Student Grading System Login Page">
    <meta name="author" content="Your Name">
    <link rel="icon" href="images/logo.jpg">
    <title>Student Grading System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
            margin-right: 150px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-form">
        <center><h3><b>Reset Password</b></h3></center>
        <form class="form-horizontal" method="post" action="reset-submit.php">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['USER']); ?>">
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
                <label for="con_password">Confirm Password:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" id="con_password" name="con_password" class="form-control" placeholder="Confirm Password" required>
                    <span class="input-group-addon toggle-password" style="cursor: pointer;">
                      <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>
            <button type="submit" name="change" class="btn btn-primary btn-block">Change Password</button>
        </form>
        <br>
        <div class="text-center">
            <a href="." class="btn btn-default">Back to Login</a>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
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
    </script>
</body>
</html>
