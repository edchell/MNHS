<?php
// Include database connection
include 'db.php';

// Check if ID is passed
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Sanitize input
    $student_id = mysqli_real_escape_string($conn, $student_id);

    // Delete query
    $sql = "DELETE FROM student_info WHERE STUDENT_ID = '$student_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Record deleted successfully!');
                window.location.href = 'rms.php?page=report'; // Replace with your main page
              </script>";
    } else {
        echo "<script>
                alert('Error deleting record: " . mysqli_error($conn) . "');
                window.location.href = 'rms.php?page=report'; // Replace with your main page
              </script>";
    }

    // Close connection
    mysqli_close($conn);
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = 'rms.php?page=report'; // Replace with your main page
          </script>";
}
?>
