<?php
include '../includes/config.php';

// Assuming you are fetching a specific student's information based on STUDENT_ID passed via GET
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 0; // Replace with appropriate ID handling

$sql = mysqli_query($conn, "SELECT * FROM student_info WHERE STUDENT_ID = $student_id");
$student = mysqli_fetch_assoc($sql);
mysqli_close($conn);
?>