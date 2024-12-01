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

// Check for existing record
$stmt = $conn->prepare("SELECT * FROM student_year_info WHERE STUDENT_ID = ? AND YEAR = ?");
$stmt->bind_param("is", $id, $yr);
$stmt->execute();
$result = $stmt->get_result();
$num_row = $result->num_rows;
$stmt->close();

if ($num_row >= 1) {
    echo json_encode(['status' => 'error', 'message' => 'Student Year Record already exists!']);
    exit;
}

// First query to get student data
$stmt = $conn->prepare("SELECT student_info.FIRSTNAME, student_info.LASTNAME FROM student_info WHERE STUDENT_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($fn, $ln);
$stmt->fetch();
$stmt->close();

if (!$fn || !$ln) {
    $fn = "Unknown";
    $ln = "Unknown";
}

// Insert history log
$history_stmt = $conn->prepare("INSERT INTO history_log (transaction, user_id, student_id, status, date_added) VALUES (?, ?, ?, ?, NOW())");
$transaction = "New Record for $fn $ln added";
$status = 'Add';
$history_stmt->bind_param("siis", $transaction, $user, $id, $status);
$history_stmt->execute();
$history_stmt->close();

// Insert new student record
$sql = "INSERT INTO student_year_info (STUDENT_ID, SCHOOL, YEAR, SECTION, TOTAL_NO_OF_YEAR, SCHOOL_YEAR, ADVISER, TDAYS_OF_CLASSES, TDAYS_PRESENT)
        VALUES ('$id', '$school', '$yr', '$sec', '$tny', '$sy', '$adv', '$Tdc', '$Tp')";
if (!mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to insert student year record.']);
    exit;
}

$last_id = mysqli_insert_id($conn);
$sc = count($subject);

// Insert subject grades
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

echo json_encode(['status' => 'success', 'message' => 'Student Record Added Successfully!']);
exit;

mysqli_close($conn);
?>
