<?php
include 'db.php';

// Check if ID is passed and valid
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Delete record from the database
    $sql = "DELETE FROM school_year WHERE SY_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Return a success message
        echo 'success';
    } else {
        // Return an error message if deletion fails
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>
