<?php
// Include your database connection file
include 'db.php'; // Adjust the filename as needed

// Check if the request is an AJAX POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare the SQL statements to delete all records from different tables
    $stmt2 = $conn->prepare("DELETE FROM `student_year_info`");
    $stmt3 = $conn->prepare("DELETE FROM `total_grades_subjects`");
    $stmt4 = $conn->prepare("DELETE FROM `student_info`");
    $stmt6 = $conn->prepare("DELETE FROM `history_log`");

    // Execute each statement and handle errors
    $success = true; // Flag to track the success of all queries

    // Delete student_year_info
    if (!$stmt2->execute()) {
        $success = false;
        echo "Error deleting records from student_year_info: " . $conn->error;
    }

    // Delete total_grades_subjects
    if (!$stmt3->execute()) {
        $success = false;
        echo "Error deleting records from total_grades_subjects: " . $conn->error;
    }

    // Delete student_info
    if (!$stmt4->execute()) {
        $success = false;
        echo "Error deleting records from student_info: " . $conn->error;
    }

    // Delete history_log
    if (!$stmt6->execute()) {
        $success = false;
        echo "Error deleting records from history_log: " . $conn->error;
    }

    // If all queries are successful, return success response
    if ($success) {
        echo "success";
    }

    // Close the statements and connection
    $stmt2->close();
    $stmt3->close();
    $stmt4->close();
    $stmt6->close();
    $conn->close();
}
?>
