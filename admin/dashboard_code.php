<?php
include '../includes/config.php';

// Fetch data for the dashboard
$totalUsersQuery = "SELECT COUNT(*) as total FROM user";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

$totalMaleQuery = "SELECT COUNT(*) as total FROM user WHERE USER_TYPE = 'male'";
$totalMaleResult = $conn->query($totalMaleQuery);
$totalMale = $totalMaleResult->fetch_assoc()['total'];

$totalFemaleQuery = "SELECT COUNT(*) as total FROM user WHERE USER_TYPE = 'female'";
$totalFemaleResult = $conn->query($totalFemaleQuery);
$totalFemale = $totalFemaleResult->fetch_assoc()['total'];

$totalStudentsQuery = "SELECT COUNT(*) as total FROM student"; // Adjust as necessary
$totalStudentsResult = $conn->query($totalStudentsQuery);
$totalStudents = $totalStudentsResult->fetch_assoc()['total'];

$totalSubjectsQuery = "SELECT COUNT(*) as total FROM subjects"; // Adjust as necessary
$totalSubjectsResult = $conn->query($totalSubjectsQuery);
$totalSubjects = $totalSubjectsResult->fetch_assoc()['total'];
?>