<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $user = $_POST['user'];
    $type = $_POST['type'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE user SET FIRSTNAME = ?, LASTNAME = ?, USER = ?, USER_TYPE = ? WHERE USER_ID = ?");
    $stmt->bind_param("ssssi", $fname, $lname, $user, $type, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
            alert('Account updated successfully');
            location.replace(document.referrer);
        </script>";
    }

    $stmt->close();
}

mysqli_close($conn);
?>
