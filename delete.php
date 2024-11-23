<?php
// Include your database connection file
include 'db.php'; // Adjust the filename as needed

// Prepare the SQL statement to delete all records
$stmt = $conn->prepare("DELETE FROM `total_grades_subjects`");

// Execute the statement
if ($stmt->execute()) {
    // Records deleted successfully
    echo "<script>alert('All records deleted successfully.');</script>";
} else {
    // Error deleting records
    echo "<script>alert('Error deleting records: " . $conn->error . "');</script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to the records page (or wherever you want)
header("Location: rms.php?page=records");
exit();
?>
