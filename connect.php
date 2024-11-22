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
        // Redirect back with an error message for hCaptcha failure
        header("Location: .?error=captcha_failed");
        exit();
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

        if (password_verify($pwd, $use['PASSWORD'])) {
            session_regenerate_id();
            $_SESSION['ID'] = $use['USER_ID'];
            $_SESSION['fname'] = $use['FIRSTNAME'];
            $id = $use['USER_ID'];

            mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged in', '$id', NOW())");
            header("Location: rms.php?page=home");
            exit();
        } else {
            header("Location: .?error=invalid_credentials");
            exit();
        }
    } else {
        header("Location: .?error=invalid_credentials");
        exit();
    }
}
?>
