<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = mysqli_query($conn, "UPDATE user SET STATUS = '' WHERE USER_ID = '$id'");
    if ($sql) {
        echo "User restore successfully.";
    } else {
        echo "Error restore user.";
    }
}

mysqli_close($conn);
?>