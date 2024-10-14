<?php
include '../includes/config.php';

// Assuming you are fetching a specific student's information based on STUDENT_ID passed via GET
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// Prepare the SQL update statement
$sql = "UPDATE student_info 
        SET 
            LRN_NO = ?, 
            LASTNAME = ?, 
            FIRSTNAME = ?, 
            MIDDLENAME = ?, 
            GENDER = ?, 
            DATE_OF_BIRTH = ?, 
            ADDRESS = ?, 
            BIRTH_PLACE = ?, 
            PARENT_GUARDIAN = ?, 
            P_ADDRESS = ?, 
            INT_COURSE_COMP = ?, 
            SCHOOL_YEAR = ?, 
            GEN_AVE = ?, 
            TOTAL_NO_OF_YEARS = ? 
        WHERE STUDENT_ID = ?";

// Initialize a prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters (adjust type definitions as needed)
    mysqli_stmt_bind_param($stmt, 'ssssssssssssssi', 
        $lrn_no, 
        $lastname, 
        $firstname, 
        $middlename, 
        $gender, 
        $dob, 
        $address, 
        $birth_place, 
        $parent_guardian, 
        $p_address, 
        $school_completed, 
        $school_year, 
        $gen_ave, 
        $total_no_of_years, 
        $student_id // Last variable for STUDENT_ID
    );

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Success message
        echo "Student information updated successfully.";
    } else {
        // Error message
        echo "Error updating student information: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing the statement: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>
