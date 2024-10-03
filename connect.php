<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('boxes.php'); // Assuming this includes your database connection

    // Use prepared statements to prevent SQL injection
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    // Prepare the statement
    $stmt = $conn->prepare("SELECT USER_ID, FIRSTNAME, PASSWORD FROM user WHERE USER = ?");
    $stmt->bind_param("s", $user); // 's' specifies the variable type => 'string'

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $use = $result->fetch_assoc();

            // Verify the password using password_verify
            if (password_verify($pwd, $use['PASSWORD'])) {
                // Login Successful
                session_regenerate_id(); // Regenerate session ID for security
                $_SESSION['ID'] = htmlspecialchars($use['USER_ID'], ENT_QUOTES, 'UTF-8'); // XSS protection
                $_SESSION['fname'] = htmlspecialchars($use['FIRSTNAME'], ENT_QUOTES, 'UTF-8');

                // Log login activity
                $id = $use['USER_ID'];
                $log_stmt = $conn->prepare("INSERT INTO history_log (transaction, user_id, date_added) VALUES (?, ?, NOW())");
                $transaction = 'logged in';
                $log_stmt->bind_param("si", $transaction, $id); // 'i' for integer
                $log_stmt->execute();

                // Redirect to home page after a short delay
                $error_message = '<div class="alert alert-success" role="alert">
                    Login Successful.
                  </div>';
                echo $error_message;
                header("refresh:2;url=rms.php?page=home");
                exit();
            } else {
                // Incorrect username or password
                $error_message = '<div class="alert alert-danger" role="alert">
                    Login Failed! Incorrect username or password.
                  </div>';
                echo $error_message; // Return error message for AJAX handling
                exit();
            }
        } else {
            // Incorrect username
            $error_message = '<div class="alert alert-danger" role="alert">
                Login Failed! Username not found.
              </div>';
            echo $error_message; // Return error message for AJAX handling
            exit();
        }
    } else {
        // Query execution failed
        $error_message = '<div class="alert alert-danger" role="alert">
            Query execution failed.
          </div>';
        echo $error_message; // Return error message for AJAX handling
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
