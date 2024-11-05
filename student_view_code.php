<?php
session_start();
include('db.php');

if (isset($_POST['submit'])) {

    // Validate input
    $lrn_no = trim($_POST['lrn_no']);
    
    // Check if LRN_NO is not empty
    if (empty($lrn_no)) {
        echo "<script>alert('Please enter LRN No.');</script>";
        header("location: student_view.php");
        exit();
    }

    // Prepare the SQL statement to prevent SQL injection
    $qry = "SELECT * FROM student_info WHERE LRN_NO = ?";
    $stmt = mysqli_prepare($conn, $qry);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $lrn_no);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Redirect to the student card page
                header("location: student_card.php?stu_id=" . urlencode($lrn_no));
                exit();
            } else {
                echo "<script>alert('Incorrect LRN No.');</script>";
                header("location: student_view.php");
                exit();
            }
        } else {
            error_log("Query execution failed: " . mysqli_error($conn)); // Log the error
            echo "<script>alert('An error occurred. Please try again.');</script>";
            header("location: student_view.php");
            exit();
        }

        mysqli_stmt_close($stmt); // Close the statement
    } else {
        error_log("Query preparation failed: " . mysqli_error($conn)); // Log the error
        echo "<script>alert('An error occurred. Please try again.');</script>";
        header("location: student_view.php");
        exit();
    }
}

// Don't forget to close the database connection
mysqli_close($conn);
?>
