<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $user = $_POST['user'];
    $type = $_POST['type'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE USER_ID = '$id'");
    $row = mysqli_fetch_assoc($query);
    
    if ($row) {
        $sql = mysqli_query($conn, "UPDATE user SET FIRSTNAME = '$fname', LASTNAME = '$lname', USER = '$user', USER_TYPE = '$type' WHERE USER_ID = '$id'");
        
        if ($sql) {
            // Success response
            echo json_encode(['status' => 'success', 'message' => 'Account updated successfully']);
        } else {
            // Error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to update the account.']);
        }
    } else {
        // User not found
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }

    mysqli_close($conn);
}
?>
