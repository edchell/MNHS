<?php
include('../includes/config.php');

// add_user.php - Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $role = $_POST['role'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password using Argon2i
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO user (LASTNAME, FIRSTNAME, USER, PASSWORD, USER_TYPE) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $lastname, $firstname, $email, $hashedPassword, $role);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>