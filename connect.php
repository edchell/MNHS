<?php
session_start();
include('script.php');

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
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Captcha Verification Failed',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'index.php';
                });
              </script>";
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

        if (isset($_SESSION['failed_attempts']) && $_SESSION['failed_attempts'] >= 3) {
            $lockout_time = $_SESSION['lockout_time'];
            $current_time = time();

            if ($current_time - $lockout_time < 30 * 60) {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Account Locked',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location = 'index.php';
                        });
                      </script>";
                exit();
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

            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location = 'rms.php?page=home';
                    });
                  </script>";
            exit();
        } else {
            $_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
            $_SESSION['lockout_time'] = time();

            if ($_SESSION['failed_attempts'] >= 3) {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Account Locked',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location = 'index.php';
                        });
                      </script>";
                exit();
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Credentials',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location = 'index.php';
                        });
                      </script>";
                exit();
            }
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Credentials',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'index.php';
                });
              </script>";
        exit();
    }
}
?>
