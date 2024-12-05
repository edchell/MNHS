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
    <!-- Include the reCAPTCHA v3 script -->
    <script src="https://www.google.com/recaptcha/api.js?render=y6LcO9JIqAAAAAL7DZAX_JTPZmxSUm0osvx5rSxaE"></script> 
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
            position: absolute; /* Stay in place */
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
            margin-right: 40%;
            padding: 20px;
            border: 1px solid #888;
            width: 60%; /* Width of the modal */
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
        <form class="form-horizontal" method="post" action="connect.php" id="loginForm">
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
                <button type="submit" name="login" id="login" class="btn btn-primary btn-block" disabled>Login</button>
            </div>
            <div class="form-group text-center">
                <a href="reset-pass-choose.php" class="btn btn-link">Forgot password?</a>
            </div>
            <input type="hidden" name="recaptcha_token" id="recaptcha_token">
        </form>
    </div>
    <!-- Modal Structure -->
    <div id="termsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 style="margin-bottom:5px;">General Terms and Conditions for Data Privacy Act of 2012 Compliance</h3>
                <div class="terms-text">
                            <p style="margin-bottom:5px;font-weight:bold;">1. Principles of Data Privacy</p>
                            <p style="magin-bottom:5px;">Organizations must adhere to these principles when handling personal data:</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li><b>Transparency:</b> Inform data subjects about how their data will be collected, processed, and used.</li>
                                <li><b>Legitimate Purpose:</b> Collect data only for lawful and specific purposes.</li>
                                <li><b>Proportionality:</b> Collect and process only data that is necessary for the declared purpose.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">2. Data Subject Rights</p>
                            <p style="magin-bottom:5px;">Individuals have the right to:</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Be informed about the processing of their personal data.</li>
                                <li>Access their data.</li>
                                <li>Object to data processing.</li>
                                <li>Correct or update their data.</li>
                                <li>Erase or block their data under certain conditions.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">3. Consent</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Obtain explicit, informed, and voluntary consent from the data subject before processing personal data.</li>
                                <li>Clearly state the purpose of data collection at the time of obtaining consent.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">4. Security Measures</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Implement organizational, physical, and technical security measures to protect personal data from unauthorized access, processing, and disposal.</li>
                                <li>Regularly review and update security measures to address emerging threats.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">5. Data Processing Standards</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Process data lawfully and in compliance with the declared purposes.</li>
                                <li>Retain data only for as long as necessary to fulfill the purpose of processing.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">6. Data Sharing and Transfer</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Obtain consent before sharing personal data with third parties, except when allowed by law.</li>
                                <li>Ensure third parties comply with the same data protection standards.</li>
                                <li>For international data transfers, ensure the recipient country has adequate data protection measures.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">7. Data Breach Management</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Notify the National Privacy Commission (NPC) and affected individuals within 72 hours of discovering a breach that poses a risk to data subjects.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">8. Appointment of a Data Protection Officer (DPO)</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Designate a DPO responsible for ensuring compliance with the DPA and acting as the point of contact for the NPC and data subjects.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">9. Regular Compliance Audits</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Conduct regular privacy impact assessments and audits to ensure compliance with the DPA and its implementing rules.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">10. Accountability</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Maintain records of processing activities.</li>
                                <li>Train staff on data privacy principles and policies.</li>
                            </ul>
                            <hr style="margin-top:20px;margin-bottom:10px;">
                            <p style="margin-bottom:5px;font-weight:bold;">Penalties for Non-Compliance</p>
                            <p style="magin-bottom:5px;">The DPA of 2012 imposes penalties for violations, including:</p>
                            <ul style="margin-left:25px;margin-bottom:7px;">
                                <li>Fines ranging from PHP 500,000 to PHP 5 million.</li>
                                <li>Imprisonment ranging from 1 to 6 years, depending on the severity of the violation.</li>
                            </ul>
                            <p style="margin-bottom:5px;font-weight:bold;">Regulatory Authority</p>
                            <p style="magin-bottom:5px;">The <b>National Privacy Commission (NPC)</b> oversees the enforcement of the DPA and issues guidelines and advisories to ensure compliance.</p>
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

        // When the user clicks the link, open the modal
        link.onclick = function(event) {
            event.preventDefault(); // Prevent the default link behavior
            modal.style.display = "block"; // Show the modal
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginButton = document.querySelector('#login');
            const termsCheckbox = document.querySelector('input[type="checkbox"]');

            // Add click event listener to the login button
            loginButton.addEventListener('click', function () {
                // Automatically check the Terms and Condition checkbox
                if (termsCheckbox) {
                    termsCheckbox.checked = true;
                }
            });

            // Modal handling for terms
            var modal = document.getElementById("termsModal");
            var link = document.getElementById("openModalLink");
            var span = document.getElementsByClassName("close")[0];

            link.onclick = function(event) {
                event.preventDefault();
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Execute reCAPTCHA and add the token to the form
            grecaptcha.ready(function () {
                grecaptcha.execute('6LcO9JIqAAAAAL7DZAX_JTPZmxSUm0osvx5rSxaE', { action: 'login' }).then(function (token) {
                    document.getElementById('recaptcha_token').value = token;
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
