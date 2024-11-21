<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize input

    // Prepare SQL statement to delete the student record
    $sql = "DELETE FROM student_info WHERE STUDENT_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success"; // Return success message
    } else {
        echo "error"; // Return error message
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
