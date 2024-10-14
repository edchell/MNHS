<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    exit();
}

include '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $para = $_POST['para']; // Capture the FOR value (Program)

    $sql = "UPDATE subjects SET SUBJECT = '$subject', DESCRIPTION = '$description', `FOR` = '$para' WHERE SUBJECT_ID = $subject_id";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: subject_list.php"); // Redirect back to the main page after updating
}
?>
