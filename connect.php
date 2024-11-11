<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errmsg_arr = array();
    $errflag = false;

    include('db.php');
    $user = $_POST['user'];
    $pwd = $_POST['pwd']; // Get the plain text password

    // Get user device info (IP + User Agent) to detect new devices
    $user_ip = $_SERVER['REMOTE_ADDR']; 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $device_hash = hash('sha256', $user_ip . $user_agent); // Generate a unique hash for the device

    // Prepare the SQL statement to prevent SQL injection
    $qry = "SELECT * FROM user WHERE USER = ? AND STATUS = ''";
    $stmt = mysqli_prepare($conn, $qry);
    mysqli_stmt_bind_param($stmt, 's', $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // User found, fetch user data
            $use = mysqli_fetch_assoc($result);

            // Check if device is new
            if (empty($use['last_device_hash']) || $use['last_device_hash'] !== $device_hash) {
                // New device detected, generate 3 random numbers (one of them is the token)
                $verification_token = rand(1000, 9999); // Token number (unique for this session)
                $random_number_1 = rand(1000, 9999);     // Random number 1
                $random_number_2 = rand(1000, 9999);     // Random number 2

                // Shuffle the numbers
                $numbers = array($verification_token, $random_number_1, $random_number_2);
                shuffle($numbers); // Shuffle so that the token isn't always in the same place

                // Store the number to be displayed on the login page (this will be the token)
                $_SESSION['verification_number_to_show'] = $numbers[0]; // Randomly display the first number
                $_SESSION['verification_token'] = $verification_token; // Save the token in the session
                $_SESSION['verification_numbers'] = $numbers; // Save all three numbers in the session
                $_SESSION['verification_user_id'] = $use['USER_ID'];


                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
                    $mail->Username   = 'mnhs.gradeinfo@gmail.com';              // SMTP username
                    $mail->Password   = 'gqbg gbmj pgpg ussr';                    // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                    $mail->Port       = 587;                                      // TCP port to connect to

                    // Recipients
                    $mail->setFrom('mnhs.gradeinfo@gmail.com', 'MNHS Grading System');
                    $mail->addAddress($use['USER']);  // Add recipient (user's email)

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'New Device Login Verification';
                    $mail->Body    = "Your login attempt is from a new device. Please verify your login by clicking the correct number:<br><br>
                                      <b>Click the correct number from the following:</b><br>
                                      <a href='verify_device.php?number={$numbers[0]}'>1. {$numbers[0]}</a><br>
                                      <a href='verify_device.php?number={$numbers[1]}'>2. {$numbers[1]}</a><br>
                                      <a href='verify_device.php?number={$numbers[2]}'>3. {$numbers[2]}</a><br><br>
                                      Click the correct number to confirm your identity.";

                    $mail->send();

                    // Redirect to the login page, where the user can click the correct number in the email
                    echo "<div class='erlert'><center><h4>" . "A verification email has been sent. Please check your email and click the correct number to proceed." . "</h4></center></div>";
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                // No new device, verify password
                if (password_verify($pwd, $use['PASSWORD'])) {
                    // Login successful
                    session_regenerate_id();
                    
                    $_SESSION['ID'] = $use['USER_ID'];
                    $_SESSION['fname'] = $use['FIRSTNAME'];
                    $id = $use['USER_ID'];

                    // Update last device hash to current
                    mysqli_query($conn, "UPDATE user SET last_device_hash = '$device_hash' WHERE USER_ID = '$id'");

                    mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged in', '$id', NOW())");

                    header("location: rms.php?page=home");
                    exit();
                } else {
                    echo "<div class='erlert'><center><h4>" . "Invalid login credentials. Please try again" . "</h4></center></div>";
                    exit();
                }
            }
        } else {
            echo "<div class='erlert'><center><h4>" . "Invalid login credentials. Please try again" . "</h4></center></div>";
            exit();
        }
    } else {
        die("Query failed");
    }
}
?>
