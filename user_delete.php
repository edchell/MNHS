<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = mysqli_query($conn, "UPDATE user SET STATUS = 'archived' WHERE USER_ID = '$id'");
    if ($sql) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user.";
    }
}

mysqli_close($conn);
?>