<?php
include 'db.php'; // Include your database connection file

if (isset($_POST['id'])) {
    $userId = intval($_POST['id']); // Get the user ID from POST request

    // Check if the user exists
    $stmt = $conn->prepare("SELECT USER_ID FROM user WHERE USER_ID = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If user exists, delete the user
        $stmt->close(); // Close the previous statement

        $stmt = $conn->prepare("DELETE FROM user WHERE USER_ID = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . $conn->error;
        }

        $stmt->close(); // Close the statement
    } else {
        echo "User does not exist.";
    }

    $conn->close(); // Close the database connection
} else {
    echo "User ID not provided.";
}
?>
