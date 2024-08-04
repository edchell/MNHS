<?php
include 'db.php';

// Get the student LRN_NO and LASTNAME from the URL
$lrn_no = mysqli_real_escape_string($conn, $_GET['lrn_no']);
$lastname = mysqli_real_escape_string($conn, $_GET['lastname']);

// Fetch student information based on LRN_NO and LASTNAME
$studentQuery = "SELECT * FROM student_info WHERE LRN_NO = '$lrn_no' AND LASTNAME = '$lastname'";
$studentResult = mysqli_query($conn, $studentQuery);

if ($studentResult && mysqli_num_rows($studentResult) > 0) {
    $student = mysqli_fetch_assoc($studentResult);

    // Fetch school year info and grades
    $gradeQuery = "
        SELECT * 
        FROM student_year_info 
        LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
        LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
        WHERE STUDENT_ID = '{$student['STUDENT_ID']}'
    ";
    $gradeResult = mysqli_query($conn, $gradeQuery);

    // Fetch school year
    $schoolYearQuery = "SELECT school_year FROM school_year WHERE status='Yes'";
    $schoolYearResult = mysqli_query($conn, $schoolYearQuery);

    // Fetch subjects and grades
    $subjectQuery = "
        SELECT * 
        FROM total_grades_subjects 
        WHERE SYI_ID = (
            SELECT SYI_ID 
            FROM student_year_info 
            WHERE STUDENT_ID = '{$student['STUDENT_ID']}'
        ) 
        ORDER BY SUBJECT
    ";
    $subjectResult = mysqli_query($conn, $subjectQuery);
} else {
    echo "<div class='alert alert-danger' role='alert'>Student not found.</div>";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grades</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        input {
            border: 0;
            outline: 0;
            background: transparent;
            border-bottom: 1px solid black;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .page-header {
            margin-top: 20px;
        }
        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-control {
            height: 30px;
            font-size: 12px;
        }
        .text-right {
            text-align: right;
        }
        .disabled-input {
            text-align: center;
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid black;
        }
        .table th, .table td {
            text-align: center;
            font-size: 10px;
        }
    </style>
    <script type="text/javascript">
        function getParameterByName(name, url) {
            if (!url) {
                url = window.location.href;
            }
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        $(document).ready(function() {
            $('#fetch').on('change', function() {
                var value = $(this).val();
                var id = getParameterByName('id');
                var val = 'id=' + encodeURIComponent(id) + '&request=' + encodeURIComponent(value);

                $.ajax({
                    type: 'POST',
                    url: 'updateRecord.php?prog=<?php echo $_GET["prog"]; ?>',
                    data: val,
                    beforeSend: function() {
                        $("#fetch-feild").html('Working on Please wait ..');
                    },
                    success: function(data) {
                        $("#fetch-feild").html(data);
                    },
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <button onclick="window.history.back()" class="back-button">Back</button>
        <h1 class="page-header"><?php echo $student['LASTNAME'] . ', ' . $student['FIRSTNAME'] . ' ' . $student['MIDDLENAME']; ?></h1>

        <div class="form-inline">
            <div class="form-group">
                <label for="fetch">Select Grade:</label>
                <select class="form-control" id="fetch">
                    <?php
                    // Fetch and display grades
                    include 'db.php';
                    $gradeQuery = "SELECT * FROM grade ORDER BY grade_id";
                    $gradeResult = mysqli_query($conn, $gradeQuery);
                    while ($grade = mysqli_fetch_assoc($gradeResult)) {
                        echo "<option value='{$grade['grade_id']}'>{$grade['grade']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-md-7 text-right">
            <?php while ($schoolYear = mysqli_fetch_assoc($schoolYearResult)) { ?>
                <a class="btn btn-success" href="rms.php?page=addrecord&id=<?php echo $_GET['id']; ?>&sy=<?php echo $schoolYear['school_year']; ?>&prog=<?php echo $_GET['prog']; ?>">
                    <i class="fa fa-plus"> Add Record</i>
                </a>
            <?php } ?>
        </div>

        <br><br>

        <input type="text" style="width:100%;text-align:center" disabled>
        <br><br>

        <div id="fetch-feild">
            <?php
            if ($gradeResult) {
                while ($gradeRow = mysqli_fetch_assoc($gradeResult)) {
                    $syi_id = $gradeRow['SYI_ID'];
            ?>
                    <div class="row">
                        <div class="col-md-6">
                            <label>School:</label>
                            <input type="text" value="<?php echo $gradeRow['SCHOOL']; ?>" disabled>
                            <br>
                            <label>Grade:</label>
                            <input type="text" value="<?php echo $gradeRow['GRADE']; ?>" disabled>
                            <br>
                            <label>Section:</label>
                            <input type="text" value="<?php echo $gradeRow['SECTION']; ?>" disabled>
                            <br>
                            <label>Total Number of Years in School:</label>
                            <input type="text" value="<?php echo $gradeRow['TOTAL_NO_OF_YEAR']; ?>" disabled>
                            <br>
                            <label>School Year:</label>
                            <input type="text" value="<?php echo $gradeRow['SCHOOL_YEAR']; ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label>Adviser:</label>
                            <input type="text" value="<?php echo $gradeRow['ADVISER_NAME']; ?>" disabled>
                            <br>
                            <label>General Average:</label>
                            <input type="text" value="<?php echo $gradeRow['GEN_AVE']; ?>" disabled>
                            <br>
                            <label>Rank:</label>
                            <input type="text" value="<?php echo $gradeRow['RANK']; ?>" disabled>
                        </div>
                    </div>
                    <br>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subjects</th>
                                <th>1st Grading</th>
                                <th>2nd Grading</th>
                                <th>3rd Grading</th>
                                <th>4th Grading</th>
                                <th>Final</th>
                                <th>Units</th>
                                <th>Passed/Failed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                                echo "<tr>";
                                echo "<td>{$subjectRow['SUBJECT']}</td>";
                                echo "<td>{$subjectRow['1ST_GRADING']}</td>";
                                echo "<td>{$subjectRow['2ND_GRADING']}</td>";
                                echo "<td>{$subjectRow['3RD_GRADING']}</td>";
                                echo "<td>{$subjectRow['4TH_GRADING']}</td>";
                                echo "<td>{$subjectRow['FINAL_GRADES']}</td>";
                                echo "<td>{$subjectRow['UNITS']}</td>";
                                echo "<td>{$subjectRow['PASSED_FAILED']}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Attendance Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Months</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Aug</th>
                                <th>Sept</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dec</th>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>March</th>
                                <th>April</th>
                                <th>May</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Days of School</td>
                                <?php
                                // Fetch and display attendance
                                $attendanceQuery = "SELECT * FROM attendance WHERE SYI_ID = '$syi_id'";
                                $attendanceResult = mysqli_query($conn, $attendanceQuery);
                                while ($attendance = mysqli_fetch_assoc($attendanceResult)) {
                                    echo "<td>{$attendance['DAYS_OF_CLASSES']}</td>";
                                }
                                ?>
                                <td><?php echo $gradeRow['TDAYS_OF_CLASSES']; ?></td>
                            </tr>
                            <tr>
                                <td>Days Present</td>
                                <?php
                                $attendanceResult = mysqli_query($conn, $attendanceQuery);
                                while ($attendance = mysqli_fetch_assoc($attendanceResult)) {
                                    echo "<td>{$attendance['DAYS_PRESENT']}</td>";
                                }
                                ?>
                                <td><?php echo $gradeRow['TDAYS_PRESENT']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
