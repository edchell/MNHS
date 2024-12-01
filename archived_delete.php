<?php
include 'db.php';

if (isset($_POST['id'])) {
    $userId = intval($_POST['id']);
    
    // Prepare a statement for safe deletion
    $stmt = $conn->prepare("DELETE FROM user WHERE USER_ID = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
