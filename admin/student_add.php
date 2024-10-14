<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    exit();
}
include '../includes/config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $lrn_no = htmlspecialchars(trim($_POST['lrn_no']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $middlename = htmlspecialchars(trim($_POST['middlename']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $address = htmlspecialchars(trim($_POST['address']));
    $birth_place = htmlspecialchars(trim($_POST['birth_place']));
    $parent_guardian = htmlspecialchars(trim($_POST['parent_guardian']));
    $p_address = htmlspecialchars(trim($_POST['p_address']));
    $school_completed = htmlspecialchars(trim($_POST['school_completed']));
    $school_year = htmlspecialchars(trim($_POST['school_year']));
    $gen_ave = htmlspecialchars(trim($_POST['gen_ave']));
    $total_no_of_years = htmlspecialchars(trim($_POST['total_no_of_years']));

    // Use prepared statements to prevent SQL injection
    $insert_query = "INSERT INTO student_info (LRN_NO, LASTNAME, FIRSTNAME, MIDDLENAME, GENDER, DATE_OF_BIRTH, ADDRESS, BIRTH_PLACE, PARENT_GUARDIAN, P_ADDRESS, INT_COURSE_COMP, SCHOOL_YEAR, GEN_AVE, TOTAL_NO_OF_YEARS) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $insert_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssssssssssss', $lrn_no, $lastname, $firstname, $middlename, $gender, $dob, $address, $birth_place, $parent_guardian, $p_address, $school_completed, $school_year, $gen_ave, $total_no_of_years);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Success message
            echo "<script>
                    alert('Student added successfully.');
                    window.location.href = 'student_list.php';
                </script>";
            exit(); 
        } else {
            // Error message
            echo "Error adding student information: " . mysqli_stmt_error($stmt);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
