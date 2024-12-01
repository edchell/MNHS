<?php
include 'db.php';

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM grade WHERE grade_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>
