<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grade = $_POST['grade'];

    if (empty($grade)) {
        echo 'error';
        exit;
    }

    $user = $_SESSION['ID'];
    $sql = "INSERT INTO grade (grade) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $grade);

    if ($stmt->execute()) {
        $log_sql = "INSERT INTO history_log (transaction, user_id, date_added) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("si", "added $grade to the grades list", $user);
        $log_stmt->execute();
        
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
