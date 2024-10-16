<?php
// Include your database connection file
include 'db.php'; // Adjust the filename as needed

// Check if the id parameter is set
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM student_info WHERE STUDENT_ID = ?");
    $stmt->bind_param("i", $student_id); // "i" denotes the type (integer)

    // Execute the statement
    if ($stmt->execute()) {
        // Record deleted successfully
        echo "<script>alert('Record deleted successfully.')</script>";
    } else {
        // Error deleting record
        echo "<script>alert('Error deleting record: ')</script>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the records page (or wherever you want)
    header("Location: rms.php?page=records");
    exit();
} else {
    // If no ID is set, redirect or show an error
    echo "No ID provided.";
    header("Location: rms.php?page=records");
    exit();
}
?>
