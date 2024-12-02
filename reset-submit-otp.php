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

// Password reset verification logic
if (isset($_POST['change'])) {
    // Sanitize user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $otp_entered = mysqli_real_escape_string($conn, $_POST['otp']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $con_password = mysqli_real_escape_string($conn, $_POST['con_password']);
    $hash_pass = password_hash($new_password, PASSWORD_ARGON2I);

    // Check if the email exists in the database
    $check_email = "SELECT * FROM user WHERE USER = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $get_email = $row['USER'];
        $stored_otp = $row['TOKEN'];
        $otp_used = $row['TOKEN_USED'];

        // Check if OTP has already been used
        if ($otp_used == 0) {
            if ($otp_entered == $stored_otp) {
                // Update the password and mark the OTP as used
                $update_password = "UPDATE user SET PASSWORD = ?, TOKEN_USED = 1 WHERE USER = ?";
                $stmt = $conn->prepare($update_password);
                $stmt->bind_param("ss", $hash_pass, $get_email);
                $update_password_run = $stmt->execute();

                if ($update_password_run) {
                    $_SESSION['status'] = "Password successfully changed.";
                    $_SESSION['status_code'] = "success";
                    header("Location: .");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Failed to update the password. Please try again.";
                    $_SESSION['status_code'] = "error";
                    header("Location: reset-change-otp.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid OTP entered.";
                $_SESSION['status_code'] = "error";
                header("Location: reset-change-otp.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "The OTP has already been used.";
            $_SESSION['status_code'] = "warning";
            header("Location: .");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Email not found.";
        $_SESSION['status_code'] = "error";
        header("Location: reset-change-otp.php");
        exit(0);
    }
}
?>
