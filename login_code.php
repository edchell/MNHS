<?php
include('includes/config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: index.php");
        exit();
    }

    // Prepare and execute query
    $query = "SELECT * FROM user WHERE USER = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['PASSWORD'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['USER_ID'];
            $_SESSION['user_email'] = $user['USER'];

            // Redirect to dashboard
            header("Location: db.php?page=dashboard");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
        header("Location: index.php");
        exit();
    }

    $stmt->close();
    $conn->close()
}
?>
