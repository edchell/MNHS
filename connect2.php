<?php
include 'db.php';

// Get the input values
$lrn_no = $_POST['lrn_no'];
$lastname = $_POST['lastname'];

// Create a SQL query to search for the student
$sql = "SELECT * FROM student_info WHERE LRN_NO = '$lrn_no' AND LASTNAME = '$lastname'";
$result = mysqli_query($conn, $sql);

// Check if any results were found
if (mysqli_num_rows($result) > 0) {
    // Output the student data
    while ($row = mysqli_fetch_assoc($result)) {
        // Display the student data in HTML
        echo '<h1>' . $row['LASTNAME'] . ', ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME'] . '</h1>';
        // Include the rest of your student information display here
    }
} else {
    echo 'No student found.';
}

mysqli_close($conn);
?>
