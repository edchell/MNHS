<?php
// Include your database connection file
include 'db.php'; // Adjust the filename as needed

// Prepare the SQL statements to delete all records from different tables
$stmt1 = $conn->prepare("DELETE FROM `notifications`");
$stmt2 = $conn->prepare("DELETE FROM `student_year_info`");
$stmt3 = $conn->prepare("DELETE FROM `total_grades_subjects`");
$stmt4 = $conn->prepare("DELETE FROM `student_info`");
// $stmt5 = $conn->prepare("DELETE FROM `subjects`");
$stmt6 = $conn->prepare("DELETE FROM `history_log`");

// Execute each statement
$success = true; // Flag to track the success of all queries

if (!$stmt1->execute()) {
    $success = false;
    echo "<script>alert('Error deleting records from notifications: " . $conn->error . "');</script>";
}
if (!$stmt2->execute()) {
    $success = false;
    echo "<script>alert('Error deleting records from student_year_info: " . $conn->error . "');</script>";
}
if (!$stmt3->execute()) {
    $success = false;
    echo "<script>alert('Error deleting records from total_grades_subjects: " . $conn->error . "');</script>";
}
if (!$stmt4->execute()) {
    $success = false;
    echo "<script>alert('Error deleting records from student_info: " . $conn->error . "');</script>";
}
if (!$stmt5->execute()) {
    $success = false;
    echo "<script>alert('Error deleting records from subjects: " . $conn->error . "');</script>";
}
if (!$stmt6->execute()) {
    $success = false;
    echo "<script>alert('Error deleting records from history_log: " . $conn->error . "');</script>";
}

// If all queries are successful, show a success message
if ($success) {
    echo "<script>alert('All records deleted successfully.');</script>";
}

// Close the statements and connection
$stmt1->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
$stmt5->close();
$stmt6->close();
$conn->close();

// Redirect to the records page (or wherever you want)
header("Location: rms.php?page=records");
exit();
?>
