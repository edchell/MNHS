<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) { // Adjust this condition as needed
    // Unset all session variables
    $_SESSION = array();

    // If desired, delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"], 
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: student_view.php");
    exit;
}

// Optionally prevent caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>