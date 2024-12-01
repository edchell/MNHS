<?php
session_start();

// Check if the user is logged in and has an ID
if (isset($_SESSION['ID'])) {
    // Include the database connection
    include 'db.php';

    // Sanitize the user ID for database safety
    $user_id = mysqli_real_escape_string($conn, $_SESSION['ID']);

    // Insert the logout record into the history_log table
    $sql = "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged out', '$user_id', NOW())";

    if (!mysqli_query($conn, $sql)) {
        // Log an error if the insert fails
        error_log("Failed to log logout action for user ID $user_id: " . mysqli_error($conn));
    }
}

// Clear session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location: ."); // Adjust to your desired location
exit();
?>
