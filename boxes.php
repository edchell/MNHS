<?php
$config = require 'box.php';

// Create a new mysqli instance
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally set the character set
$conn->set_charset("utf8mb4");

// Function to sanitize inputs (if needed)
function sanitizeInput($input) {
    global $conn; // Access the connection variable
    return $conn->real_escape_string(trim($input));
}

// Example usage of sanitizeInput
// $user_input = sanitizeInput($_POST['user_input']);

// Use prepared statements for queries
// $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
// $stmt->bind_param("s", $user_input);
// $stmt->execute();
// $result = $stmt->get_result();
// ...
?>
