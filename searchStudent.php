<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
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
</head>
<body>
    <?php
    include 'boxes.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $lastname = $_POST['lastname'];

        // Sanitize input
        $id = mysqli_real_escape_string($conn, $id);
        $lastname = mysqli_real_escape_string($conn, $lastname);

        // Create a SQL query to search for the student
        $sql = "SELECT * FROM student_info WHERE STUDENT_ID = '$id' AND LASTNAME = '$lastname'";
        $result = mysqli_query($conn, $sql);

        // Check if any results were found
        if (mysqli_num_rows($result) > 0) {
            // Output the student data
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<button onclick="window.history.back()" class="back-button">Back</button>';
                echo '<h1 class="page-header">' . htmlspecialchars($row['LASTNAME']) . ', ' . htmlspecialchars($row['FIRSTNAME']) . ' ' . htmlspecialchars($row['MIDDLENAME']) . '</h1>';

                // Output select grade dropdown
                echo '<div class="col-md-5">
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="focusedInput">Select Grade:</label>
                                <select class="form-control" style="height:30px;font-size:12px" id="fetch">
                                    <option value="">--Select Grade--</option>';
                                    // Populate with actual grades from database
                                    $gradesQuery = mysqli_query($conn, "SELECT * FROM grade ORDER BY grade_id");
                                    while ($grade = mysqli_fetch_assoc($gradesQuery)) {
                                        echo '<option value="' . htmlspecialchars($grade['grade_id']) . '">' . htmlspecialchars($grade['grade']) . '</option>';
                                    }
                echo '    </select>
                            </div>
                        </div>
                      </div>';

                // Display grades, attendance, etc.
                $syi_query = mysqli_query($conn, "SELECT * FROM student_year_info 
                    LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
                    LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
                    WHERE STUDENT_ID = '$id'");
                    
                while ($syi = mysqli_fetch_assoc($syi_query)) {
                    $syi_id = $syi['SYI_ID'];
                    echo '<div class="col-md-7 text-right">';
                $schoolYearQuery = mysqli_query($conn, "SELECT school_year FROM school_year WHERE status='Yes'");
                while ($sy = mysqli_fetch_assoc($schoolYearQuery)) {
                    }
                    echo '</div>';
                    echo '<br><br><input type="text" style="width:100%;text-align:center" disabled><br><br>';

                    // Start of DataTable
                    echo '<div id="fetch-feild">
                            <div class="col-md-12">
                                <label style="font-size:6" for="">School</label>
                                <input type="text" style="width:450px;text-align:center" value="' . htmlspecialchars($syi["SCHOOL"]) . '" disabled>
                                <label style="font-size:6" for="">Grade</label>
                                <input type="text" style="width:150px;text-align:center" value="' . htmlspecialchars($syi["grade"]) . '" disabled>
                                <label style="font-size:6" for="">Section</label>
                                <input type="text" style="width:100px;text-align:center" value="' . htmlspecialchars($syi["SECTION"]) . '" disabled>
                                <br>
                                <label style="font-size:6" for="">Total number of years in school to date</label>
                                <input type="text" style="width:290px;text-align:center" value="' . htmlspecialchars($syi["TOTAL_NO_OF_YEAR"]) . '" disabled>
                                <label style="font-size:6" for="">School Year</label>
                                <input type="text" style="width:150px;text-align:center" value="' . htmlspecialchars($syi["SCHOOL_YEAR"]) . '" disabled>
                                <br>
                                <table id="gradesTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>Subjects</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>Final</th>
                                            <th>Units</th>
                                            <th>Passed or Failed</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                    $gradesQuery = mysqli_query($conn, "SELECT * FROM total_grades_subjects WHERE SYI_ID = '$syi_id' ORDER BY SUBJECT");
                    while ($grade = mysqli_fetch_assoc($gradesQuery)) {
                        $subj_id = $grade['SUBJECT'];
                        $subjectQuery = mysqli_query($conn, "SELECT * FROM subjects WHERE SUBJECT_ID = '$subj_id'");
                        while ($subject = mysqli_fetch_assoc($subjectQuery)) {
                            echo '<tr>
                                    <td>' . htmlspecialchars(trim($subject['SUBJECT'])) . '</td>
                                    <td>' . htmlspecialchars($grade['1ST_GRADING']) . '</td>
                                    <td>' . htmlspecialchars($grade['2ND_GRADING']) . '</td>
                                    <td>' . htmlspecialchars($grade['3RD_GRADING']) . '</td>
                                    <td>' . htmlspecialchars($grade['4TH_GRADING']) . '</td>
                                    <td>' . htmlspecialchars($grade['FINAL_GRADES']) . '</td>
                                    <td>' . htmlspecialchars($grade['UNITS']) . '</td>
                                    <td>' . htmlspecialchars($grade['PASSED_FAILED']) . '</td>
                                  </tr>';
                        }
                    }

                    echo '        </tbody>
                                </table>
                            </div>
                        </div>';
                }
            }
        } else {
            echo 'No student found.';
        }

        mysqli_close($conn);
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#gradesTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
</body>
</html>