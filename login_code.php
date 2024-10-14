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

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
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

        // Verify the password using Argon2i
        if (password_verify($password, $hashedPassword)) {
            // Regenerate session ID
            session_regenerate_id(true);

            // Store user's first name and last name in session
            $_SESSION['FIRSTNAME'] = $firstName;
            $_SESSION['LASTNAME'] = $lastName;
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
