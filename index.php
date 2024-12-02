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
        #termsModal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Width of the modal */
            max-width: 600px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Makes content scrollable if too long */
            max-height: 80vh; /* Prevents the modal from becoming too tall */
        }

        .terms-text {
            max-height: 300px;
            overflow-y: auto; /* Makes the terms text scrollable */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .agree-btn {
            display: block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        .agree-btn:hover {
            background-color: #45a049;
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
                    <input type="checkbox"> I agree to the
                    <a href="#" id="openModalLink">Terms and Condition</a>
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
        <!-- Modal Structure -->
        <div id="termsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Terms and Conditions</h2>
                <div class="terms-text">
                    <p><strong>1. Introduction</strong></p>
                    <p>These Terms and Conditions govern your use of our website. By using our site, you agree to these terms...</p>
                    
                    <p><strong>2. Privacy Policy</strong></p>
                    <p>We respect your privacy and handle your personal data with care...</p>

                    <p><strong>3. User Responsibilities</strong></p>
                    <p>As a user, you agree not to engage in illegal activities on our platform...</p>
                    
                    <p>For full details, visit our <a href="terms.html" target="_blank">Terms and Conditions page</a>.</p>
                </div>

                <!-- Agree button -->
                <button id="agreeBtn" class="agree-btn">I Agree</button>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#toggle-password');
            const passwordField = document.querySelector('#pwd');

            togglePassword.addEventListener('click', function () {
                const type = passwordField.type === 'password' ? 'text' : 'password';
                passwordField.type = type;

                // Toggle eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });

        // Get the modal
        var modal = document.getElementById("termsModal");

        // Get the link that opens the modal
        var link = document.getElementById("openModalLink");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // Get the "I Agree" button
        var agreeBtn = document.getElementById("agreeBtn");

        // When the user clicks the link, open the modal
        link.onclick = function(event) {
            event.preventDefault(); // Prevent the default link behavior
            modal.style.display = "block"; // Show the modal
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks the "I Agree" button, close the modal
        agreeBtn.onclick = function() {
            alert("You have accepted the Terms and Conditions.");
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
