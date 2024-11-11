<?php
session_start();

// Get the clicked number from the query string
$clicked_number = $_GET['number'];

// Check if the clicked number matches the correct verification token
if (!isset($_SESSION['verification_token']) || !isset($clicked_number)) {
    echo "<div class='erlert'><center><h4>" . "Invalid verification request." . "</h4></center></div>";
    exit();
}

// Check if the clicked number matches the verification token
if ($clicked_number == $_SESSION['verification_token']) {
    // Correct number clicked, complete the login
    include('db.php');
    $user_id = $_SESSION['verification_user_id'];

    // Optionally, you can update device info as verified
    mysqli_query($conn, "UPDATE user SET last_device_hash = '" . $_SESSION['device_hash'] . "' WHERE USER_ID = '$user_id'");

    // Complete the login process
    header("Location: rms.php?page=home");
    exit();
} else {
    // Incorrect number clicked, cancel the login
    session_destroy(); // Clear session data
    echo "<div class='erlert'><center><h4>Invalid verification. Login attempt canceled.</h4></center></div>";
    exit();
}
?>
