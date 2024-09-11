<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $userId = $_POST['user_id'];

    // Database connection
    $conn = new mysqli('127.0.0.1', 'u510162695_grading_db', '1Grading_db', 'u510162695_grading_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete a record
    $sql = "UPDATE user SET STATUS = 'Archived' WHERE USER_ID = ?";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'unarchived') {
    $userId = $_POST['user_id'];

    // Database connection
    $conn = new mysqli('127.0.0.1', 'u510162695_grading_db', '1Grading_db', 'u510162695_grading_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to delete a record
    $sql = "UPDATE user SET STATUS = '' WHERE USER_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "User unarchived successfully.";
    } else {
        echo "Error unarchived user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
