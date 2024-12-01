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
    mysqli_query($conn, $sql);
}

// Clear session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location: ."); // Adjust to your desired location
exit();
?>
