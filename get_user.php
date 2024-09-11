<?php
include 'db.php';

if (isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE USER_ID = '$user_id'");
    $row = mysqli_fetch_assoc($sql);
    echo json_encode($row);
} else {
    echo json_encode(array('error' => 'No user ID provided'));
}

mysqli_close($conn);
?>
