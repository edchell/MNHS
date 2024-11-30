<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('db.php');

    $hcaptcha_response = $_POST['h-captcha-response'];
    $secret_key = 'ES_56abb957bf7444c5a5b606122f2c5933'; // Replace with your hCaptcha secret key

    // Verify hCaptcha response
    $verify_url = 'https://hcaptcha.com/siteverify';
    $data = [
        'secret' => $secret_key,
        'response' => $hcaptcha_response,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    // Check if lockout time is set and not expired
    if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
        $lockout_time_remaining = $_SESSION['lockout_time'] - time();
        $minutes_remaining = ceil($lockout_time_remaining / 60);

        // Set the lockout time and message in session to display on the client
        $_SESSION['lockout_message'] = "Too many failed attempts. Please try again in $minutes_remaining minute(s).";
        $_SESSION['lockout_code'] = "error";
        header("Location: ."); // Redirect to the login page or the relevant page
        exit(0);
    }
    
    $context  = stream_context_create($options);
    $result = file_get_contents($verify_url, false, $context);
    $verification = json_decode($result);

    if (!$verification->success) {
        $_SESSION['status'] = "Captcha Verification Failed";
        $_SESSION['status_code'] = "error";
        header("Location: .");
        exit(0);
    }

    // Validate user credentials
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    $qry = "SELECT * FROM user WHERE USER = ? AND STATUS = ''";
    $stmt = mysqli_prepare($conn, $qry);
    mysqli_stmt_bind_param($stmt, 's', $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $use = mysqli_fetch_assoc($result);

        if (isset($_SESSION['failed_attempts']) && $_SESSION['failed_attempts'] >= 3) {
            $lockout_time = $_SESSION['lockout_time'];
            $current_time = time();

            if ($current_time - $lockout_time < 30 * 60) {
                $_SESSION['status'] = "Account Locked";
                $_SESSION['status_code'] = "error";
                header("Location: .");
                exit(0);
            } else {
                unset($_SESSION['failed_attempts']);
                unset($_SESSION['lockout_time']);
            }
        }

        if (password_verify($pwd, $use['PASSWORD'])) {
            unset($_SESSION['failed_attempts']);
            unset($_SESSION['lockout_time']);

            session_regenerate_id();
            $_SESSION['ID'] = $use['USER_ID'];
            $_SESSION['fname'] = $use['FIRSTNAME'];

            $id = $use['USER_ID'];
            mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged in', '$id', NOW())");

            $_SESSION['login_success'] = true;
            header("Location: .");
            exit();
        } else {
            $_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
            $_SESSION['lockout_time'] = time();

            if ($_SESSION['failed_attempts'] >= 3) {
                $_SESSION['status'] = "Account Locked";
                $_SESSION['status_code'] = "error";
                header("Location: .");
                exit(0);
            } else {
                $_SESSION['status'] = "Invalid Credentials";
                $_SESSION['status_code'] = "error";
                header("Location: .");
                exit(0);
            }
        }
    } else {
        $_SESSION['status'] = "Invalid Credentials";
        $_SESSION['status_code'] = "error";
        header("Location: .");
        exit(0);
    }
}
?>
