<?php
session_start();
include 'db.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

    function submit_reset($get_email, $token) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host        = 'smtp.gmail.com';
            $mail->SMTPAuth    = true;
            $mail->Username    = 'mnhs.gradeinfo@gmail.com';
            $mail->Password    = 'gqbg gbmj pgpg ussr';
            $mail->SMTPSecure  = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port        = 587;

            $mail->setFrom('mnhs.gradeinfo@gmail.com', 'MNHS Grading System');
            $mail->addAddress($get_email);

            $mail->isHTML(true);
            $mail->Subject = 'Here is your link to Reset the password of your MNHS Grading System';
            $mail->Body = "
            <html>
            <body>
                <div class='content'>
                    <p>Hello,</p>
                    <p>We received a request to reset your password. Click the link below to reset it:</p>
                    <p><a href='https://mnhs-gradeinfo.com/reset-change.php?token=" . urlencode($token) . "'>Reset Password</a></p>
                    <p>If you did not request a password reset link, please ignore this email.</p>
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

    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $token = md5(rand());

        $check_email = "SELECT USER FROM user WHERE USER = '$email' AND STATUS = ''";
        $check_email_run = mysqli_query($conn, $check_email);

        if(mysqli_num_rows($check_email_run) > 0) {
            $row = mysqli_fetch_array($check_email_run);
            $get_email = $row['USER'];

            $update_token = "UPDATE user SET TOKEN = '$token', TOKEN_USED = 0 WHERE USER = '$email'";
            $update_token_run = mysqli_query($conn, $update_token);

            if($update_token_run) {
                if(submit_reset($get_email, $token)){
                    $_SESSION['status'] = "We email you the reset password link.";
                    $_SESSION['status_code'] = "success";
                    header("Location: reset-password.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Email sending failed. Try again.";
                    $_SESSION['status_code'] = "error";
                    header("Location: reset-password.php");
                    exit(0);
                }
            }
        }
    }


    if(isset($_POST['change'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $con_password = mysqli_real_escape_string($conn, $_POST['con_password']);
        $hash_pass = password_hash($_POST['new_password'], PASSWORD_ARGON2I);

        $check_email = "SELECT * FROM user WHERE USER = '$email'";
        $check_email_run = mysqli_query($conn, $check_email);

        if(mysqli_num_rows($check_email_run) > 0) {
            $row = mysqli_fetch_array($check_email_run);
            $get_email = $row['USER'];
            $token_used = $row['TOKEN_USED'];

            if($token_used == 0) {
                $update_password = "UPDATE user SET PASSWORD = '$hash_pass', TOKEN_USED = 1 WHERE USER = '$get_email'";
                $update_password_run = mysqli_query($conn, $update_password);

                if($update_password_run) {
                    $_SESSION['status'] = "Password Successfully Changed.";
                    $_SESSION['status_code'] = "success";
                    header("Location: .");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Failed to update the passwod. Please try again.";
                    $_SESSION['status_code'] = "error";
                    header("Location: reset_change.php");
                    exit(0);
                }
            } else {
                    $_SESSION['status'] = "Link already been used.";
                    $_SESSION['status_code'] = "warning";
                    header("Location: .");
                    exit(0);
            }
        }
    }
?>