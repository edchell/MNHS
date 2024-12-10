<?php
session_start();

$timeout_duration = 1800; // 30 minutes

// Check if the session exists and if the user has an ID
if (isset($_SESSION['ID'])) {
    // Check if the session has been idle for longer than the allowed time
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        // If the session is expired, log the user out and reset session
        logout();
    }

    // Update the last activity time on each page load
    $_SESSION['last_activity'] = time();

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
        $update_query = "UPDATE user SET LOGS = 0 WHERE USER_ID = '$user_id"; // 'i' indicates an integer

        if (!mysqli_query($conn, $update_query)) {
            // Log an error if the insert fails
            error_log("Failed to log logout action for user ID $user_id: " . mysqli_error($conn));
        }

        // Clear session variables and destroy session
        session_unset(); // Clear session variables
        session_destroy(); // Destroy the session

        // Redirect to the homepage or login page
        header("Location: ."); // Adjust to your desired location
        exit();
    }
} else {
    // If the session doesn't exist, redirect to the login page
    header("Location: .");
    exit();
}
?>