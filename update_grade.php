<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $grade = $_POST['grade'];

    // Validate input
    if (empty($grade)) {
        echo 'error';
        exit;
    }

    $sql = "UPDATE grade SET grade='$grade' WHERE grade_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
