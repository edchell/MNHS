<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errmsg_arr = array();
    $errflag = false;

    include('db.php');
    $user = $_POST['user'];
    $pwd = $_POST['pwd']; // Get the plain text password

    // Prepare the SQL statement to prevent SQL injection
    $qry = "SELECT * FROM user WHERE USER = ?";
    $stmt = mysqli_prepare($conn, $qry);
    mysqli_stmt_bind_param($stmt, 's', $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // User found, fetch user data
            $use = mysqli_fetch_assoc($result);

            // Verify the password using Argon2i
            if (password_verify($pwd, $use['PASSWORD'])) {
                // Login Successful
                session_regenerate_id();
                
                $_SESSION['ID'] = $use['USER_ID'];
                $_SESSION['fname'] = $use['FIRSTNAME'];
                $id = $use['USER_ID'];
                
                mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged in', '$id', NOW())");

                header("location: rms.php?page=home");
                exit();
            } else {
                echo "<div class='erlert'><center><h4>" . "Incorrect USER or PASSWORD." . "</h4></center></div>";
                exit();
            }
        } else {
            echo "<div class='erlert'><center><h4>" . "Incorrect USER or PASSWORD." . "</h4></center></div>";
            exit();
        }
    } else {
        die("Query failed");
    }
}
?>
