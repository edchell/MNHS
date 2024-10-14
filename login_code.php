<?php
// login_code.php

// Include database connection
include('includes/config.php'); // Adjust the path as needed

session_start(); // Start a new session

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    // Check for potential SQL injection patterns
    if (preg_match('/(union|select|insert|delete|update|drop|--|#)/i', $email)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input detected.']);
        exit();
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT FIRSTNAME, LASTNAME, PASSWORD FROM user WHERE USER = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($firstName, $lastName, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Store user's first name and last name in session
            $_SESSION['FIRSTNAME'] = $firstName;
            $_SESSION['LASTNAME'] = $lastName;

            // Optionally store email or other user info
            $_SESSION['USER'] = $email;

            echo json_encode(['status' => 'success', 'redirect' => 'admin/dashboard.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }

    $stmt->close();
    $conn->close();
}
?>
