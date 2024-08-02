<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $userId = $_POST['user_id'];

    // Database connection
    $conn = new mysqli('your_host', 'your_username', 'your_password', 'your_database');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete a record
    $sql = "DELETE FROM users WHERE USER_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
