<?php
session_start();

// Redirect any URLs containing '.php' to remove the extension.
$request = $_SERVER['REQUEST_URI'];
if (strpos($request, '.php') !== false) {
    $new_url = str_replace('.php', '', strtok($request, '?'));
    if ($_SERVER['QUERY_STRING']) {
        $new_url .= '?' . $_SERVER['QUERY_STRING'];
    }
    header("Location: $new_url", true, 301);
    exit();
}

// Display SweetAlert notifications if set in the session.
if(isset($_SESSION['status']) && $_SESSION['status'] !='')
{
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            confirmButtonText: "OK"
        });
    });
    </script>
    <?php
    unset($_SESSION['status']);
}


// Display success message for login.
if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                showConfirmButton: true
            }).then(() => {
                window.location.href = 'rms.php?page=home';
            });
        });
    </script>
    <?php
    unset($_SESSION['login_success']);
}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css">
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: flex-end; /* Align the login form to the right */
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
        <center><h3><b>Please Login</b></h3></center>
        <?php if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']): ?>
                        <?php
                        $lockout_time_remaining = $_SESSION['lockout_time'] - time();
                        $minutes_remaining = ceil($lockout_time_remaining / 60);
                        ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Account Locked',
                                    text: "Your account is locked. Please try again later.",
                                    icon: 'warning',
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false, 
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                }).then(() => {
                                    setTimeout(function() {
                                        window.location.reload(); 
                                    }, 1000);
                                });
                            });
                        </script>
                    <?php endif; ?>
        <form class="form-horizontal" method="post" action="connect.php">
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
                <label>
                    <input type="checkbox" id="terms-checkbox" class="mr-2"> I agree to the 
                    <a href="javascript:void(0);" class="terms-link" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                </label>
            </div>
            <div class="form-group">
                <div class="h-captcha" data-sitekey="cdbe03de-503a-4774-952a-8ddebc4c571e"></div>
            </div>
            <div class="form-group">
                <button type="submit" name="login" id="login" class="btn btn-primary btn-block" disabled>Login</button>
            </div>
            <div class="form-group text-center">
                <a href="reset-pass-choose.php" class="btn btn-link">Forgot password?</a>
            </div>
        </form>
    </div>
    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>1. Terms of Use</h4>
                    <p>By accessing this system, you agree to the terms and conditions set forth...</p>

                    <h4>2. User Responsibilities</h4>
                    <p>You are responsible for maintaining the confidentiality of your account...</p>

                    <h4>3. Data Privacy</h4>
                    <p>We value your privacy and ensure that your personal data is securely stored...</p>

                    <!-- Add more terms here as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.querySelector('form');
            const loginButton = document.querySelector('#login');
            
            // Check if geolocation is supported
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    function (position) {
                        // If user allows location access
                        loginButton.disabled = false;
                        loginForm.querySelectorAll('input, button').forEach(function (element) {
                            element.disabled = false;
                        });
                    },
                    function (error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            Swal.fire({
                                title: 'Permission Denied',
                                text: "Please allow location access to use this login page.",
                                icon: 'warning',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            });
                        }
                        if (error.code === error.POSITION_UNAVAILABLE || error.code === error.TIMEOUT) {
                            Swal.fire({
                                title: 'Location Lost',
                                text: "Location access was lost. The form will reload.",
                                icon: 'error',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            });
                        }
                    }
                );
            } else {
                Swal.fire({
                title: 'Geolocation Not Supported',
                text: "Geolocation is not supported by this browser.",
                icon: 'error',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
                }).then(() => {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#toggle-password');
            const passwordField = document.querySelector('#pwd');
            const termsCheckbox = document.querySelector('#terms-checkbox');
            const loginButton = document.querySelector('#login');

            togglePassword.addEventListener('click', function () {
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;

                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Enable login button only if checkbox is checked
            termsCheckbox.addEventListener('change', function () {
                loginButton.disabled = !this.checked;
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
