<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    exit();
}

include '../includes/config.php';

// Assuming you are fetching a specific student's information based on STUDENT_ID passed via GET
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0; // Use intval for sanitization

// Prepare the SQL query to prevent SQL injection
$sql = mysqli_prepare($conn, "SELECT * FROM student_info WHERE STUDENT_ID = ?");
mysqli_stmt_bind_param($sql, 'i', $student_id); // 'i' indicates the parameter type is an integer

// Execute the statement
mysqli_stmt_execute($sql);

// Get the result
$result = mysqli_stmt_get_result($sql);

// Fetch the student's information
$student = mysqli_fetch_assoc($result);

// Close the statement and connection
mysqli_stmt_close($sql);
mysqli_close($conn);

// Optional: Check if the student exists
if (!$student) {
    echo "No student found.";
    exit();
}

// Now you can use $student for further processing or display
?>
