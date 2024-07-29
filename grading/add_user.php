<?php
include 'db.php'; // Include your database connection file

// Check for POST data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data (adjust validation as needed)
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    // Perform query to insert new user into database
    $query = "INSERT INTO user (LASTNAME, FIRSTNAME, USER, PASSWORD, USER_TYPE) 
              VALUES ('$lname', '$fname', '$user', '$pwd', '$type')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
