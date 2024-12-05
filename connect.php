<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('db.php');

    // reCAPTCHA v3 response from the form
    $recaptcha_response = $_POST['recaptcha_token']; // This should match the name of the hidden input in your form
    $secret_key = '6LcO9JIqAAAAAMVKtFs9g8CD0NDxMnbi2yaiEKtN'; // Replace with your Google reCAPTCHA secret key

    // Verify reCAPTCHA v3 response
    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret_key,
        'response' => $recaptcha_response,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($verify_url, false, $context);
    $verification = json_decode($result);

    // If reCAPTCHA verification fails
    if (!$verification->success) {
        $_SESSION['status'] = "reCAPTCHA Verification Failed. Please try again.";
        $_SESSION['status_code'] = "error";
        header("Location: .");
        exit(0);
    }

    // Initialize session variables if not already set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout_time'] = null;
    }

    // Check if user is locked out
    if ($_SESSION['lockout_time'] && time() < $_SESSION['lockout_time']) {
        $lockout_time_remaining = $_SESSION['lockout_time'] - time();
        $minutes_remaining = ceil($lockout_time_remaining / 60);
        header("Location: .");
        exit(0);
    }

    // Get user credentials from the form
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    // Query to fetch the user record from the database
    $qry = "SELECT * FROM user WHERE USER = ? AND STATUS = ''";
    $stmt = mysqli_prepare($conn, $qry);
    mysqli_stmt_bind_param($stmt, 's', $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $use = mysqli_fetch_assoc($result);

        // Check if the user is locked out due to failed login attempts
        if (isset($_SESSION['failed_attempts']) && $_SESSION['failed_attempts'] >= 3) {
            $lockout_time = $_SESSION['lockout_time'];
            $current_time = time();

            if ($current_time - $lockout_time < 30 * 60) {
                // User is still locked out, return without proceeding
                $_SESSION['status'] = "You are locked out due to multiple failed login attempts. Please try again later.";
                $_SESSION['status_code'] = "error";
                header("Location: .");
                exit(0);
            } else {
                // Unlock the user if lockout period has expired
                unset($_SESSION['failed_attempts']);
                unset($_SESSION['lockout_time']);
            }
        }

        // Check if the provided password matches the stored hashed password
        if (password_verify($pwd, $use['PASSWORD'])) {
            session_regenerate_id(true); // Regenerate session ID to prevent session fixation attacks

            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_time'] = null;

            $_SESSION['ID'] = $use['USER_ID'];
            $_SESSION['fname'] = $use['FIRSTNAME'];

            // Log the login event in history
            $id = $use['USER_ID'];
            mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged in', '$id', NOW())");

            // // Update user logs
            // $update_query = mysqli_prepare($conn, "UPDATE user SET LOGS = 1 WHERE USER_ID = ?");
            // mysqli_stmt_bind_param($update_query, 'i', $id);

            // if (mysqli_stmt_execute($update_query)) {
            //     // Successfully updated the user status
            //     $_SESSION['login_success'] = true;
            //     header("Location: .");
            //     exit();
            // } else {
            //     // Handle query failure
            //     $_SESSION['status'] = "Error updating user status";
            //     $_SESSION['status_code'] = "error";
            //     header("Location: .");
            //     exit(0);
            // }

            $_SESSION['login_success'] = true;
            header("Location: .");
            exit();
        } else {
            // Increment failed login attempts on invalid password
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['lockout_time'] = time() + 300; // Lock out for 5 minutes
            } else {
                $_SESSION['status'] = "Invalid Credentials";
            }
            $_SESSION['status_code'] = "error";
            header("Location: .");
            exit(0);
        }
    } else {
        // User not found or inactive, increment failed login attempts
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lockout_time'] = time() + 300; // Lock out for 5 minutes
        } else {
            $_SESSION['status'] = "Invalid Credentials";
        }
        $_SESSION['status_code'] = "error";
        header("Location: .");
        exit(0);
    }
}
?>
