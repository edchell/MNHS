<?php
// Define database connection details
$servername = '127.0.0.1';
$username = 'u510162695_grading_db';
$password = '1Grading_db';
$dbname = 'u510162695_grading_db';

// Function to connect to the database
function getDbConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Handle POST request for deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($action === 'delete') {
        // Delete user (archive user)
        $conn = getDbConnection();
        $sql = "UPDATE user SET STATUS = 'Archived' WHERE USER_ID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo "User archived successfully.";
        } else {
            echo "Error archiving user: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

    } elseif ($action === 'unarchive') {
        // Unarchive user
        $conn = getDbConnection();
        $sql = "UPDATE user SET STATUS = '' WHERE USER_ID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo "User unarchived successfully.";
        } else {
            echo "Error unarchiving user: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

    } else {
        echo "Invalid action.";
    }
} else {
    echo "Invalid request.";
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE USER_ID = $id");
    if ($row = mysqli_fetch_assoc($sql)) {
        echo json_encode($row);
    }
    mysqli_close($conn);
}
?>