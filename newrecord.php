<?php
session_start(); // Start the session

include 'db.php';

$id = $_POST['id'];
$school = $_POST['school'];
$yr = $_POST['yr'];
$sec = $_POST['sec'];
$tny = $_POST['tny'];
$sy = $_POST['sy'];
$adv = $_POST['adviser'];
$subject = $_POST['subj'];
$una = $_POST['1st'];
$ikaduwa = $_POST['2nd'];
$ikatlo = $_POST['3rd'];
$ikaapat = $_POST['4th'];
$f = $_POST['final'];
$a = $_POST['action'];
$month = $_POST['month'];
$dc = $_POST['dc'];
$p = $_POST['p'];
$Tdc = $_POST['Tdc'];
$Tp = $_POST['Tp'];
$user = $_SESSION['ID'];

// Query to check for existing records
$search_qry = mysqli_query($conn, "SELECT student_info.FIRSTNAME, student_info.LASTNAME, student_year_info.* FROM student_year_info 
LEFT JOIN student_info ON student_year_info.STUDENT_ID = student_info.STUDENT_ID 
WHERE student_year_info.STUDENT_ID = '$id' AND YEAR ='$yr'");

$row = mysqli_fetch_assoc($search_qry);
$student_firstname = $row['FIRSTNAME'];
$student_lastname = $row['LASTNAME'];
$student = $student_firstname . ' ' . $student_lastname;
$num_row = mysqli_num_rows($search_qry);

if ($num_row >= 1) {
    echo "<script>
    alert('Student Year Record already exists!');
    location.replace(document.referrer);
    </script>";
} else {
    // Insert new student record
    $sql = mysqli_query($conn, "INSERT INTO student_year_info
        (STUDENT_ID, SCHOOL, YEAR, SECTION, TOTAL_NO_OF_YEAR, SCHOOL_YEAR, ADVISER, TDAYS_OF_CLASSES, TDAYS_PRESENT)
        VALUES('$id','$school', '$yr', '$sec', '$tny', '$sy', '$adv', '$Tdc', '$Tp')");

    $last_id = mysqli_insert_id($conn); // Get the ID of the new record
    $sc = count($subject);
    
    // Insert subject grades for the student
    for ($w = 0; $w < $sc; $w++) {
        if ($subject[$w] != '') {
            mysqli_query($conn, "INSERT INTO total_grades_subjects (STUDENT_ID, SYI_ID, SUBJECT, 1ST_GRADING, 2ND_GRADING, 3RD_GRADING, 4TH_GRADING, FINAL_GRADES, PASSED_FAILED)
            VALUES('$id', '$last_id', '$subject[$w]', '$una[$w]', '$ikaduwa[$w]', '$ikatlo[$w]', '$ikaapat[$w]', '$f[$w]', '$a[$w]')");
        }
    }

    // Handle attendance
    $mc = count($month);
    for ($i = 0; $i < $mc; $i++) {
        mysqli_multi_query($conn, "INSERT INTO attendance (STUDENT_ID, SYI_ID, MONTH, DAYS_OF_CLASSES, DAYS_PRESENT)
            VALUES('$id', '$last_id', '$month[$i]', '$dc[$i]', '$p[$i]')");
    }

    // Calculate general average
    $query = mysqli_query($conn, "SELECT *, COUNT(TGS_ID) as tg_count, SUM(FINAL_GRADES) as fin_grade FROM total_grades_subjects WHERE SYI_ID = '$last_id'");
    while ($row = mysqli_fetch_assoc($query)) {
        $ga = $row['fin_grade'] / $row['tg_count'];
        mysqli_query($conn, "UPDATE student_year_info SET GEN_AVE = '$ga' WHERE SYI_ID = '".$row['SYI_ID']."'");
    }

    // Insert notification after the new student record is added
    $users_query = mysqli_query($conn, "SELECT USER_ID FROM user WHERE USER_ID = 'ADMINISTRATOR' AND STATUS = ''");
while ($user = mysqli_fetch_assoc($users_query)) {
    $user_id = $user['USER_ID'];

    // Insert a notification for each user except the one who added the record
    mysqli_query($conn, "INSERT INTO notifications (user_id, student_id, status) 
        VALUES ('$user_id', '$id', 'New')");
}

        echo "<script>
        alert('Student Record Added Successfully!');
        window.location.href = 'rms.php?page=record&id={$id}';
        </script>";
        exit;
}

mysqli_close($conn);
?>