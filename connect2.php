<?php
include 'db.php';

// Check if POST data is available
if (isset($_POST['lrn_no']) && isset($_POST['lastname'])) {
    // Get the input values
    $lrn_no = $_POST['lrn_no'];
    $lastname = $_POST['lastname'];

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM student_info WHERE LRN_NO = ? AND LASTNAME = ?");
    $stmt->bind_param("ss", $lrn_no, $lastname);
    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results were found
    if ($result->num_rows > 0) {
        // Output the student data
        while ($row = $result->fetch_assoc()) {
            // Display the student data in HTML
            echo '<h1>' . htmlspecialchars($row['LASTNAME']) . ', ' . htmlspecialchars($row['FIRSTNAME']) . ' ' . htmlspecialchars($row['MIDDLENAME']) . '</h1>';
            // Include the rest of your student information display here
        }
    } else {
        echo 'No student found.';
    }

    // Close the statement
    $stmt->close();
} else {
    echo 'Invalid input.';
}

// Close the database connection
$conn->close();
?>
