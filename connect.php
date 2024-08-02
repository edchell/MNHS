<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db.php'); // Assuming this includes your database connection

    $user = mysqli_real_escape_string($conn, $_POST['user']); // Sanitize input
    $pwd = md5($_POST['pwd']); // Hash the password

    $qry = "SELECT * FROM user WHERE USER = '$user' AND PASSWORD = '$pwd'";
    $result = mysqli_query($conn, $qry);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Login Successful
            session_regenerate_id(); // Regenerate session ID for security
            $use = mysqli_fetch_assoc($result);

            $_SESSION['ID'] = $use['USER_ID'];
            $_SESSION['fname'] = $use['FIRSTNAME'];
            $id = $use['USER_ID'];
            
            // Log login activity
            mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged in', '$id', NOW())");


            // Redirect to home page after a short delay
            header("refresh:2;url=rms.php?page=home");
            exit();
        } else {
            // Incorrect username or password
			$error_message = '<div class="alert alert-success" role="alert">
                    Login Failed!
                  </div>';
            echo $error_message; // Return error message for AJAX handling
            exit();
        }
    } else {
        // Query execution failed
        $error_message = "Query failed";
    }
}

?>