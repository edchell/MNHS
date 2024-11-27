<?php
// Include database connection (adjust according to your project)
include('db.php');

// Check if the notification ID is provided in the POST data
if (isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];

    // Update the notification status to 'read'
    $query = "UPDATE history_log SET status = 'Read' WHERE log_id = '$notification_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        
    } else {
        // Return an error response
        echo 'Error marking notification as read';
    }
} else {
    echo 'Notification ID is missing';
}
?>
