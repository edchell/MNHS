<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['subject_id'])) {
        $subject_id = intval($input['subject_id']);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM subjects WHERE SUBJECT_ID = ?");
        $stmt->bind_param('i', $subject_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
}

mysqli_close($conn);
?>
