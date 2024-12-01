<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $grade = $_POST['grade'];

    if (empty($grade)) {
        echo 'error';
        exit;
    }

    $user = $_SESSION['ID'];
    $sql = "UPDATE grade SET grade = ? WHERE grade_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $grade, $id);

    if ($stmt->execute()) {
        $log_sql = "INSERT INTO history_log (transaction, user_id, date_added) VALUES (?, ?, NOW())";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("si", "updated $id in the grades list", $user);
        $log_stmt->execute();

        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>