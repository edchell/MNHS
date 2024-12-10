<?php
session_start();

    // Include the database connection
    include 'db.php';

    // Sanitize the user ID for database safety
    $user_id = mysqli_real_escape_string($conn, $_SESSION['ID']);

    // Insert the logout record into the history_log table (if logging out)
    if (isset($_GET['logout'])) {
        $sql = "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged out', '$user_id', NOW())";

        if (!mysqli_query($conn, $sql)) {
            // Log an error if the insert fails
            error_log("Failed to log logout action for user ID $user_id: " . mysqli_error($conn));
        }

        // Update the user's status to logged out by setting LOGS = 0
        $update_query = mysqli_prepare($conn, "UPDATE user SET LOGS = 0 WHERE USER_ID = ?");
        mysqli_stmt_bind_param($update_query, 'i', $user_id); // 'i' indicates an integer

        if (!mysqli_stmt_execute($update_query)) {
            // Log an error if the update fails
            error_log("Failed to update LOGS for user ID $user_id: " . mysqli_error($conn));
        }

        // Clear session variables and destroy session
        logout();
    }
    
function logout() {
    // Clear session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the homepage or login page
    header("Location: ."); // Adjust to your desired location
    exit();
}
?>
