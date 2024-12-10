<?php
session_start();

$timeout_duration = 1800; // 30 minutes

// Check if the session exists and if the user has an ID
if (isset($_SESSION['ID'])) {
    // Check if the session has been idle for longer than the allowed time
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        logout();
    }

    // Update the last activity time on each page load
    $_SESSION['last_activity'] = time();

    // Include the database connection
    include 'db.php';

    // Sanitize the user ID for database safety
    $user_id = (int)$_SESSION['ID']; // Cast to integer for safety

    // Insert the logout record into the history_log table (if logging out)
    if (isset($_GET['logout'])) {
        error_log("Logout initiated for user ID: $user_id");

        $sql = "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged out', '$user_id', NOW())";

        if (!mysqli_query($conn, $sql)) {
            error_log("Failed to log logout action for user ID $user_id: " . mysqli_error($conn));
        }

        // Update the user's status to logged out by setting LOGS = 0
        $update_query = mysqli_prepare($conn , "UPDATE user SET LOGS = 0 WHERE USER_ID = ?");
        mysqli_stmt_bind_param($update_query, 'i', $user_id);

        if (!mysqli_stmt_execute($update_query)) {
            error_log("Failed to update LOGS for user ID $user_id: " . mysqli_stmt_error($update_query));
        } else {
            error_log("Successfully updated LOGS for user ID $user_id");
        }

        // Clear session variables and destroy session
        logout();
    }
} else {
    // If the session doesn't exist, redirect to the login page
    header("Location: .");
    exit();
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