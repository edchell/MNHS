<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $user = $_POST['user'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_ARGON2I); // Use Argon2i for hashing
    $type = $_POST['type'];

    $sql = "INSERT INTO user (FIRSTNAME, LASTNAME, PASSWORD, USER, USER_TYPE)
            VALUES ('$fname', '$lname', '$pwd', '$user', '$type')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('New account successfully recorded!');
            location.href = 'rms.php?page=users'; // Fixed typo here
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
