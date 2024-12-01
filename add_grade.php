<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grade = $_POST['grade'];

    if (empty($grade)) {
        echo 'error';
        exit;
    }

    $sql = "INSERT INTO grade (grade) VALUES ('$grade')";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error';
    }

    mysqli_close($conn);
}
?>
