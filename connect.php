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

    $context  = stream_context_create($options);
    $result = file_get_contents($verify_url, false, $context);
    $verification = json_decode($result);

    if (!$verification->success) {
        $_SESSION['status'] = "Captcha Verification Failed";
        $_SESSION['status_code'] = "error";
        header("Location: .");
        exit();
    }

    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE EMAIL='$user'");
    $use = mysqli_fetch_assoc($query);

    if ($use && password_verify($pwd, $use['PASSWORD'])) {
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
        $_SESSION['status'] = "Invalid Credentials";
        $_SESSION['status_code'] = "error";

        $_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
        $_SESSION['lockout_time'] = time();

        if ($_SESSION['failed_attempts'] >= 3) {
            $_SESSION['status'] = "Account Locked";
            $_SESSION['status_code'] = "error";
            header("Location: .");
            exit();
        }

        header("Location: .");
        exit();
    }
}
?>
