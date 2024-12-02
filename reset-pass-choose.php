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
        .reset-links {
            margin-top: 20px;
        }
        .reset-links a {
            display: block;
            margin: 5px 0;
            text-decoration: none;
            color: #000;
            text-align: center;
        }
        .reset-links a:hover {
            text-decoration: none;
        }
        .reset-link {
        	border: 1px solid rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.3);
            padding: 10px;
            border-radius: 10px;
        }
        .reset-otp {
        	border: 1px solid rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.3);
            padding: 10px;
            border-radius: 10px;
        }
        .back-login {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-form" id="login_modal" role="dialog">
        <center><h3><b>Choose Reset Password</b></h3></center>

        <!-- Reset password links -->
        <div class="reset-links">
            <a href="reset-password-link.php" class="reset-link btn btn-default"><b>Reset via Email Link</b><br><small>Receive a code via email</small></a>
            <a href="reset-password-otp.php" class="reset-otp btn btn-default"><b>Reset via Email OTP</b><br><small>Receive a code via email</small></a>
        </div>
        <div class="back-login">
        	<a href="." class="btn btn-primary">Back to login</a>
        </div>
    </div>

<script src="assets/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>