<?php
session_start();
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

// Function to send OTP email
function submit_otp($get_email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host        = 'smtp.gmail.com';
        $mail->SMTPAuth    = true;
        $mail->Username    = 'mnhs.gradeinfo@gmail.com';
        $mail->Password    = 'gqbg gbmj pgpg ussr'; // Ensure you use a secure password or app-specific password
        $mail->SMTPSecure  = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port        = 587;

        $mail->setFrom('mnhs.gradeinfo@gmail.com', 'MNHS Grading System');
        $mail->addAddress($get_email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for resetting password for MNHS Grading System';
        $mail->Body = "
        <html>
        <body>
            <div class='content'>
                <p>Hello,</p>
                <p>We received a request to reset your password. Use the OTP below to proceed:</p>
                <p><strong>$otp</strong></p>
                <p>If you did not request a password reset, please ignore this email.</p>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if (isset($_POST['submit'])) {
    // Sanitize user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $otp = rand(10000000, 99999999); // Generate a 6-digit OTP

    // Check if the email exists and has no status set
    $check_email = "SELECT USER FROM user WHERE USER = ? AND STATUS = ''";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $get_email = $row['USER'];

        // Store OTP in the database (no expiry now)
        $update_otp = "UPDATE user SET TOKEN = ?, TOKEN_USED = 0 WHERE USER = ?";
        $stmt = $conn->prepare($update_otp);
        $stmt->bind_param("is", $otp, $email);
        $update_otp_run = $stmt->execute();

        if ($update_otp_run) {
            if (submit_otp($get_email, $otp)) {

                $_SESSION['email_success'] = true;
                header("Location: reset-password-otp.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Failed to send OTP. Try again.";
                $_SESSION['status_code'] = "error";
                header("Location: reset-password-otp.php");
                exit(0);
            }
        }
    } else {
        $_SESSION['status'] = "Email not found or invalid.";
        $_SESSION['status_code'] = "error";
        header("Location: reset-password-otp.php");
        exit(0);
    }
}


// ============= Submit Password Change ============
if (isset($_POST['submit_password'])) {
    // Sanitize user input
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $email = $_SESSION['email_for_reset']; // Get the email from session

    // Validate if the passwords match
    if ($new_password !== $confirm_password) {
        $_SESSION['status'] = "Passwords do not match. Please try again.";
        $_SESSION['status_code'] = "error";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }

    // Password strength validation (at least 8 characters, one uppercase, one number)
    if (strlen($new_password) < 8) {
        $_SESSION['status'] = "Password must be at least 8 characters long.";
        $_SESSION['status_code'] = "warning";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }

    if (!preg_match('/[A-Z]/', $new_password)) {
        $_SESSION['status'] = "Password must contain at least one uppercase letter.";
        $_SESSION['status_code'] = "warning";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }

    if (!preg_match('/[a-z]/', $new_password)) {
        $_SESSION['status'] = "Password must contain at least one lowercase letter.";
        $_SESSION['status_code'] = "warning";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }

    if (!preg_match('/[0-9]/', $new_password)) {
        $_SESSION['status'] = "Password must contain at least one number.";
        $_SESSION['status_code'] = "warning";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }

    // Check if the password contains at least one special character
    if (!preg_match('/[\W_]/', $new_password)) {  // \W matches any non-word character (not a letter or number), _ includes the underscore
        $_SESSION['status'] = "Password must contain at least one special character.";
        $_SESSION['status_code'] = "warning";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }

    // Hash the password securely using Argon2i or Bcrypt
    $hashed_password = password_hash($new_password, PASSWORD_ARGON2I);

    // Update the password in the database
    $update_password_query = "UPDATE user SET PASSWORD = ?, TOKEN_USED = 1 WHERE USER = ?";
    $stmt = $conn->prepare($update_password_query);
    $stmt->bind_param("ss", $hashed_password, $email);
    $update_run = $stmt->execute();

    if ($update_run) {
        // Password updated successfully, clear the session and redirect
        $_SESSION['status'] = "Your password has been successfully updated.";
        $_SESSION['status_code'] = "success";
        unset($_SESSION['email_for_reset']);  // Clear the email session after password reset
        header("Location: .");  // Redirect to login page
        exit(0);
    } else {
        // Something went wrong with the database update
        $_SESSION['status'] = "Failed to update password. Please try again.";
        $_SESSION['status_code'] = "error";
        header("Location: reset-change-otp.php");  // Redirect back to the form
        exit(0);
    }
}


// =============== Verify OTP ================ //
if (isset($_GET['otp'])) {
    $otp_entered = mysqli_real_escape_string($conn, $_GET['otp']);

    // Query the database to check if the OTP is valid and matches
    $check_otp_query = "SELECT * FROM user WHERE TOKEN = ? AND TOKEN_USED = 0";
    $stmt = $conn->prepare($check_otp_query);
    $stmt->bind_param("s", $otp_entered);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // OTP is valid and not used
        $row = $result->fetch_assoc();
        $user_email = $row['USER'];  // Get the email associated with the OTP
        
        // Mark OTP as used (if you wish to prevent further usage)
        $update_otp = "UPDATE user SET TOKEN_USED = 1 WHERE USER = ?";
        $stmt = $conn->prepare($update_otp);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();

        $_SESSION['email_for_reset'] = $user_email;  // Store email in session to use for password reset
        $_SESSION['status'] = "OTP verified successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: reset-change-otp.php");  // Redirect to the page for password reset
        exit(0);
    } else {
        // OTP is either invalid or already used
        $_SESSION['status'] = "Invalid OTP or OTP has already been used.";
        $_SESSION['status_code'] = "error";
        header("Location: reset-password-otp.php");  // Redirect back to OTP page
        exit(0);
    }
} else {
    // If OTP is not provided
    $_SESSION['status'] = "OTP is missing.";
    $_SESSION['status_code'] = "error";
    header("Location: reset-password-otp.php");  // Redirect back to OTP page
    exit(0);
}
?>
