<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    exit();
}

include '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $para = $_POST['para']; // FOR (Program) value

    // SQL to insert the new subject into the database
    $sql = "INSERT INTO subjects (SUBJECT, DESCRIPTION, `FOR`) VALUES ('$subject', '$description', '$para')";
    
    if (mysqli_query($conn, $sql)) {
        echo "New subject added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: subject_list.php"); // Redirect back to the main page after adding
}
?>
