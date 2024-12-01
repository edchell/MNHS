<?php
include('auth.php');
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    // Validation for the grade input
    if (preg_match("/\S+/", $_POST['grade']) === 0) {
        $errors['grade'] = "* Grade is required.";
    }

    if (count($errors) === 0) {
        $grade = $_POST['grade'];
        $user = $_SESSION['ID'];

        if ($_POST['id'] == "") {
            // Add new grade
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
        } else {
            // Update existing grade
            $id = $_POST['id'];
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
        }
    } else {
        echo 'error';
    }

    $conn->close();
    exit;
}
?>