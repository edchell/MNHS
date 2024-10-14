<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    exit();
}

include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['USER_ID'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE user SET FIRSTNAME = ?, LASTNAME = ?, USER = ?, USER_TYPE = ? WHERE USER_ID = ?");
    $stmt->bind_param("ssssi", $firstname, $lastname, $email, $usertype, $userId);

    if ($stmt->execute()) {
        // Redirect or show success message
        header("Location: users.php"); // Redirect back to user list
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
