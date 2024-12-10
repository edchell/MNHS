<?php
session_start();

if (isset($_POST['logout'])) { // Fixed to $_POST
    include 'db.php';

    $user_id = mysqli_real_escape_string($conn, $_SESSION['ID']);

    $sql = "INSERT INTO history_log (transaction, user_id, date_added) VALUES ('logged out', '$user_id', NOW())";

    if (!mysqli_query($conn, $sql)) {
        error_log("Failed to log logout action for user ID $user_id: " . mysqli_error($conn));
        echo json_encode(['success' => false, 'message' => 'Failed to log logout action.']);
        exit();
    }

    $update_query = "UPDATE user SET LOGS = 0 WHERE USER_ID = '$user_id'"; // Added quotes around $user_id

    if (!mysqli_query($conn, $update_query)) {
        error_log("Failed to update user status for user ID $user_id: " . mysqli_error($conn));
        echo json_encode(['success' => false, 'message' => 'Failed to update user status.']);
        exit();
    }

    session_unset();
    session_destroy();

    echo json_encode(['success' => true, 'message' => 'Logged out successfully.']);
    exit();
}

// Session timeout handling
$timeout_duration = 1800;

if (isset($_SESSION['ID'])) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
        logout();
    }
    $_SESSION['last_activity'] = time();
} else {
    header("Location: .");
    exit();
}
?>