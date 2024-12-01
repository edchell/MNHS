<?php
session_start();
include 'db.php';

$syi_id = $_POST['syi'];
$id = $_POST['id'];
$adv = $_POST['adviser'];
$tg_id = $_POST['tg_id'];
$subject = $_POST['subj'];
$una = $_POST['1st'];
$ikaduwa = $_POST['2nd'];
$ikatlo = $_POST['3rd'];
$ikaapat = $_POST['4th'];
$f = $_POST['final'];
$action = $_POST['action'];
$att_id = $_POST['att_id'];
$dc = $_POST['dc'];
$Tdc = $_POST['Tdc'];
$att_d = $_POST['att_d'];
$pp = $_POST['pp'];
$Tp = $_POST['Tp'];
$user = $_SESSION["ID"];

try {
    // Insert new total grades for each subject if action is not empty
    $subc = count($subject);
    for ($q = 0; $q < $subc; $q++) {
        if ($action[$q] != "") {
            $query = "INSERT INTO total_grades_subjects (STUDENT_ID, SYI_ID, SUBJECT, 1ST_GRADING, 2ND_GRADING, 3RD_GRADING, 4TH_GRADING, FINAL_GRADES, PASSED_FAILED)
                      VALUES('$id', '$syi_id', '$subject[$q]', '$una[$q]', '$ikaduwa[$q]', '$ikatlo[$q]', '$ikaapat[$q]', '$f[$q]', '$action[$q]')";
            mysqli_query($conn, $query);
        }
    }

    // Insert into history log for update
    $query = mysqli_query($conn, "SELECT * FROM student_info WHERE STUDENT_ID = '$id'");
    while ($row = mysqli_fetch_assoc($query)) {
        $student = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
        mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added)
                             VALUES ('Updated $student academic record', '$user', NOW())");
    }

    // Update existing total grades for each subject
    $sc = count($tg_id);
    for ($w = 0; $w < $sc; $w++) {
        $query = "UPDATE total_grades_subjects SET SUBJECT='$subject[$w]', 1ST_GRADING='$una[$w]', 2ND_GRADING='$ikaduwa[$w]', 3RD_GRADING='$ikatlo[$w]', 
                  4TH_GRADING='$ikaapat[$w]', FINAL_GRADES='$f[$w]', PASSED_FAILED='$action[$w]' WHERE TGS_ID = '$tg_id[$w]'";
        mysqli_query($conn, $query);
    }

    // Update attendance for days of classes
    $mc = count($att_id);
    for ($i = 0; $i < $mc; $i++) {
        $query = "UPDATE attendance SET DAYS_OF_CLASSES='$dc[$i]' WHERE ATT_ID='$att_id[$i]'";
        mysqli_query($conn, $query);
    }

    // Update attendance for days present
    $mc2 = count($att_d);
    for ($z = 0; $z < $mc2; $z++) {
        $query = "UPDATE attendance SET DAYS_PRESENT='$pp[$z]' WHERE ATT_ID='$att_d[$z]'";
        mysqli_query($conn, $query);
    }

    // Calculate and update the average grade
    $gen = mysqli_query($conn, "SELECT SUM(FINAL_GRADES) as fin_gra, COUNT(TGS_ID) as gra_count FROM total_grades_subjects WHERE SYI_ID='$syi_id'");
    $fgen = mysqli_fetch_assoc($gen);
    $ga = $fgen['fin_gra'] / $fgen['gra_count'];

    // Update student year info
    $query = "UPDATE student_year_info SET ADVISER='$adv', TDAYS_OF_CLASSES='$Tdc', TDAYS_PRESENT='$Tp' WHERE SYI_ID='$syi_id'";
    mysqli_query($conn, $query);

    // Return a JSON response
    echo json_encode(['status' => 'success', 'message' => 'Student record updated successfully']);
} catch (Exception $e) {
    // Return an error response
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
} finally {
    mysqli_close($conn);
}
?>