<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include your database connection file
include 'db.php'; // Adjust the filename as needed

// Disable foreign key checks to prevent constraint issues
$conn->query("SET FOREIGN_KEY_CHECKS=0");

// Prepare the SQL statements to delete all records from different tables
$stmt1 = $conn->prepare("DELETE FROM notifications");
$stmt2 = $conn->prepare("DELETE FROM student_year_info");
$stmt3 = $conn->prepare("DELETE FROM total_grades_subjects");
$stmt4 = $conn->prepare("DELETE FROM student_info");
$stmt6 = $conn->prepare("DELETE FROM history_log");

$success = true; // Flag to track the success of all queries

// Execute each statement and check for errors
$errors = []; // Array to store errors

if (!$stmt1 || !$stmt1->execute()) {
    $success = false;
    $errors[] = "Error deleting records from notifications: " . $conn->error;
}
if (!$stmt2 || !$stmt2->execute()) {
    $success = false;
    $errors[] = "Error deleting records from student_year_info: " . $conn->error;
}
if (!$stmt3 || !$stmt3->execute()) {
    $success = false;
    $errors[] = "Error deleting records from total_grades_subjects: " . $conn->error;
}
if (!$stmt4 || !$stmt4->execute()) {
    $success = false;
    $errors[] = "Error deleting records from student_info: " . $conn->error;
}
if (!$stmt6 || !$stmt6->execute()) {
    $success = false;
    $errors[] = "Error deleting records from history_log: " . $conn->error;
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS=1");

// Close the statements
if ($stmt1) $stmt1->close();
if ($stmt2) $stmt2->close();
if ($stmt3) $stmt3->close();
if ($stmt4) $stmt4->close();
if ($stmt6) $stmt6->close();

// Close the connection
$conn->close();

// Redirect with SweetAlert
if ($success) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'All records have been deleted successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'rms.php?page=records';
        });
    </script>";
} else {
    // Display errors with SweetAlert
    $errorMessages = implode('\\n', $errors);
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'Some errors occurred:\\n$errorMessages',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'rms.php?page=records';
        });
    </script>";
}
exit();
?>
