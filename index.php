<?php
session_start();

// Redirect to clean URLs without ".php"
$request = $_SERVER['REQUEST_URI'];
if (strpos($request, '.php') !== false) {
    $new_url = str_replace('.php', '', strtok($request, '?'));
    if ($_SERVER['QUERY_STRING']) {
        $new_url .= '?' . $_SERVER['QUERY_STRING'];
    }
    header("Location: $new_url", true, 301);
    exit();
}

include('includes/script.php');
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
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <center><h3><b>Please Login</b></h3></center>
        <div class="error-message" id="error-message">Location access is required to use this form.</div>
        <form class="form-horizontal" method="post" action="connect">
            <div class="form-group">
                <label for="user">Email:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="email" class="form-control" id="user" name="user" placeholder="Enter Email" autocomplete="off" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" disabled>
                    <span class="input-group-addon" id="toggle-password" style="cursor: pointer;">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="h-captcha" data-sitekey="cdbe03de-503a-4774-952a-8ddebc4c571e"></div>
            </div>
            <div class="form-group">
                <button type="submit" id="login" class="btn btn-primary btn-block" disabled>Login</button>
            </div>
            <div class="form-group text-center">
                <a href="reset-password" class="btn btn-link">Forgot password?</a>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const formInputs = document.querySelectorAll('#user, #pwd');
        const loginButton = document.querySelector('#login');
        const errorMessage = document.querySelector('#error-message');
        let watchId;

        function enableForm() {
            formInputs.forEach(input => input.disabled = false);
            loginButton.disabled = false;
            errorMessage.style.display = 'none';
        }

        function disableForm(message) {
            formInputs.forEach(input => input.disabled = true);
            loginButton.disabled = true;
            errorMessage.textContent = message || "Location access is required to use this form.";
            errorMessage.style.display = 'block';
        }

        const urlParams = new URLSearchParams(window.location.search);
        const errorParam = urlParams.get('error');
        if (errorParam === 'account_locked') {
            disableForm("You have been locked out due to too many failed attempts. Please try again later.");
            return;
        }

        if (navigator.geolocation) {
            watchId = navigator.geolocation.watchPosition(
                position => {
                    enableForm();
                },
                error => {
                    if (error.code === error.PERMISSION_DENIED) {
                        disableForm("Please allow location access to enable login.");
                    } else {
                        disableForm("Unable to retrieve location. Please try again.");
                    }
                },
                { enableHighAccuracy: true }
            );
        } else {
            disableForm("Geolocation is not supported by this browser.");
        }

        window.addEventListener('beforeunload', () => {
            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#toggle-password');
        const passwordField = document.querySelector('#pwd');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
    </script>
</body>
</html>
