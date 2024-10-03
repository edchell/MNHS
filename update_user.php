<?php
include 'db.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $sql = "UPDATE user SET FIRSTNAME = '$fname', LASTNAME = '$lname', USER = '$user', USER_TYPE = '$type' WHERE USER_ID = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }

    mysqli_close($conn);
} else {
    echo 'error';
}
?>
