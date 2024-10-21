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
        echo "<script>
                alert('Account updated successfully');
                location.replace(document.referrer);
              </script>";
    }
}

mysqli_close($conn);
?>