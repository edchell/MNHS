<?php
$host = 'localhost';
$user = "u510162695_grading_db";
$password = "1Grading_db";
$database = "u510162695_grading_db";
// $user = 'root';
// $password = '';
// $database = 'grading_db';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8");

?>
