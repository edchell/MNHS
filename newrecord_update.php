<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get student ID and school year
    $studentId = mysqli_real_escape_string($conn, $_POST['id']);
    $sy = mysqli_real_escape_string($conn, $_POST['sy']);

    // Loop through each subject and its corresponding grades
    foreach ($_POST['subject'] as $index => $subject) {
        // Get grades for each subject
        $firstGrading = mysqli_real_escape_string($conn, $_POST['1st'][$index]);
        $secondGrading = mysqli_real_escape_string($conn, $_POST['2nd'][$index]);
        $thirdGrading = mysqli_real_escape_string($conn, $_POST['3rd'][$index]);
        $fourthGrading = mysqli_real_escape_string($conn, $_POST['4th'][$index]);
        $finalGrade = mysqli_real_escape_string($conn, $_POST['final'][$index]);
        $action = mysqli_real_escape_string($conn, $_POST['action'][$index]);

        // Prepare the update query
        $updateQuery = "
            UPDATE total_grades_subjects 
            SET 
                1ST_GRADING = '$firstGrading', 
                2ND_GRADING = '$secondGrading', 
                3RD_GRADING = '$thirdGrading', 
                4TH_GRADING = '$fourthGrading', 
                FINAL_GRADES = '$finalGrade', 
                PASSED_FAILED = '$action' 
            WHERE SYI_ID = (
                SELECT SYI_ID FROM student_year_info WHERE STUDENT_ID = '$studentId' AND SY = '$sy'
            ) AND SUBJECT = '$subject'
        ";

        // Execute the update query
        if (!mysqli_query($conn, $updateQuery)) {
            echo "Error updating grades: " . mysqli_error($conn);
        }
    }

    // Redirect or output success message
    header('Location: rms.php?page=addrecord_update&id=' . urlencode($studentId) . '&sy=' . urlencode($sy) . '&prog=' . urlencode($_GET['prog'])); // Adjust to your success page
    exit();
}

mysqli_close($conn);
?>
