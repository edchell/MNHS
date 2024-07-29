<?php
include 'db.php';
session_start(); // Start the session to access $_SESSION

// Retrieve POST data and sanitize it
$id = mysqli_real_escape_string($conn, $_POST['id']);
$school = mysqli_real_escape_string($conn, $_POST['school']);
$yr = mysqli_real_escape_string($conn, $_POST['yr']);
$sec = mysqli_real_escape_string($conn, $_POST['sec']);
$tny = mysqli_real_escape_string($conn, $_POST['tny']);
$sy = mysqli_real_escape_string($conn, $_POST['sy']);
$au = mysqli_real_escape_string($conn, $_POST['au']);
$lu = mysqli_real_escape_string($conn, $_POST['lu']);
$adv = mysqli_real_escape_string($conn, $_POST['adviser']);
$tbca = mysqli_real_escape_string($conn, $_POST['class']);
$rank = mysqli_real_escape_string($conn, $_POST['rank']);
$subject = isset($_POST['subj']) ? $_POST['subj'] : [];
$una = isset($_POST['1st']) ? $_POST['1st'] : [];
$ikaduwa = isset($_POST['2nd']) ? $_POST['2nd'] : [];
$ikatlo = isset($_POST['3rd']) ? $_POST['3rd'] : [];
$ikaapat = isset($_POST['4th']) ? $_POST['4th'] : [];
$u = isset($_POST['units']) ? $_POST['units'] : [];
$f = isset($_POST['final']) ? $_POST['final'] : [];
$a = isset($_POST['action']) ? $_POST['action'] : [];
$month = isset($_POST['month']) ? $_POST['month'] : [];
$dc = isset($_POST['dc']) ? $_POST['dc'] : [];
$p = isset($_POST['p']) ? $_POST['p'] : [];
$Tdc = isset($_POST['Tdc']) ? $_POST['Tdc'] : [];
$Tp = isset($_POST['Tp']) ? $_POST['Tp'] : [];
$user = $_SESSION['ID'];

// Prepare the search query
$search_qry = mysqli_query($conn, "SELECT * FROM student_year_info LEFT JOIN student_info ON student_year_info.STUDENT_ID = student_info.STUDENT_ID WHERE student_year_info.STUDENT_ID = '$id' AND student_year_info.YEAR = '$yr'");
if ($search_qry === false) {
    die('Error: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($search_qry);
$student = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
$num_row = mysqli_num_rows($search_qry);

if ($num_row >= 1) {
    echo "<script>
    alert('Student Year Record already exists!');
    location.replace(document.referrer);
    </script>";
} else {
    // Insert data into student_year_info
    $sql = "INSERT INTO student_year_info
        (STUDENT_ID, SCHOOL, YEAR, SECTION, TOTAL_NO_OF_YEAR, SCHOOL_YEAR, ADVANCE_UNIT, LACK_UNIT, ADVISER, RANK, TO_BE_CLASSIFIED, TDAYS_OF_CLASSES, TDAYS_PRESENT, ACTION)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $action = 'Promoted'; // This is a string
    $stmt->bind_param("isssssssssssss", $id, $school, $yr, $sec, $tny, $sy, $au, $lu, $adv, $rank, $tbca, $Tdc, $Tp, $action);
    $stmt->execute();
    $last_id = $stmt->insert_id;

    // Log history
    $stmt = $conn->prepare("INSERT INTO history_log (transaction, user_id, date_added) VALUES (?, ?, NOW())");
    $transaction = "added record of $student";
    $stmt->bind_param("ss", $transaction, $user);
    $stmt->execute();

    // Insert data into total_grades_subjects
    $stmt = $conn->prepare("INSERT INTO total_grades_subjects (STUDENT_ID, SYI_ID, SUBJECT, 1ST_GRADING, 2ND_GRADING, 3RD_GRADING, 4TH_GRADING, UNITS, FINAL_GRADES, PASSED_FAILED)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sc = count($subject);
    for ($w = 0; $w < $sc; $w++) {
        if (!empty($subject[$w])) {
            $stmt->bind_param("iissssssds", $id, $last_id, $subject[$w], $una[$w], $ikaduwa[$w], $ikatlo[$w], $ikaapat[$w], $u[$w], $f[$w], $a[$w]);
            $stmt->execute();
        }
    }

    // Insert data into attendance
    $stmt = $conn->prepare("INSERT INTO attendance (STUDENT_ID, SYI_ID, MONTH, DAYS_OF_CLASSES, DAYS_PRESENT) VALUES (?, ?, ?, ?, ?)");
    $mc = count($month);
    for ($i = 0; $i < $mc; $i++) {
        $stmt->bind_param("iisss", $id, $last_id, $month[$i], $dc[$i], $p[$i]);
        $stmt->execute();
    }

    // Calculate and update the general average
    $query = mysqli_query($conn, "SELECT COUNT(TGS_ID) AS tg_count, SUM(FINAL_GRADES) AS fin_grade FROM total_grades_subjects WHERE SYI_ID = '$last_id'");
    $row = mysqli_fetch_assoc($query);
    $ga = $row['tg_count'] > 0 ? $row['fin_grade'] / $row['tg_count'] : 0; // Avoid division by zero
    $stmt = $conn->prepare("UPDATE student_year_info SET GEN_AVE = ? WHERE SYI_ID = ?");
    $stmt->bind_param("di", $ga, $last_id);
    $stmt->execute();

    // Update the action based on failure counts
    $query2 = mysqli_query($conn, "SELECT * FROM total_grades_subjects WHERE SYI_ID = '$last_id' AND PASSED_FAILED = 'FAILED'");
    $counts = mysqli_num_rows($query2);
    $query3 = mysqli_query($conn, "SELECT * FROM grade WHERE grade_id = '$yr'");
    $row3 = mysqli_fetch_assoc($query3);
    $tbca2 = $row3['grade'];

    $action = ($counts > 2) ? 'Retained' : 'Conditional(Promoted)';
    $stmt = $conn->prepare("UPDATE student_year_info SET ACTION = ?, TO_BE_CLASSIFIED = ? WHERE SYI_ID = ?");
    $stmt->bind_param("ssi", $action, $tbca2, $last_id);
    $stmt->execute();

    // Redirect to the record page
    header('Location: rms.php?page=record&id=' . $id);
}

// Close the connection
mysqli_close($conn);
?>
