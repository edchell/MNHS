<?php
include 'db.php';

if (isset($_GET['grade_id']) && isset($_GET['student_id'])) {
    $gradeId = $_GET['grade_id'];
    $studentId = $_GET['student_id'];

    // Use prepared statement to prevent SQL injection
    $sql = mysqli_prepare($conn, "SELECT * FROM student_year_info 
                                  LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id
                                  LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id
                                  WHERE STUDENT_ID = ? AND grade.grade_id = ?");
    mysqli_stmt_bind_param($sql, 'ii', $studentId, $gradeId);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-md-12">
            <label style="font-size:6" for="">School</label>
            <input type="text" style="width:450px;text-align:center" value="<?php echo $row['SCHOOL'] ?>" disabled>

            <label style="font-size:6" for="">Grade</label>
            <input type="text" style="width:150px;text-align:center" value="<?php echo $row['grade']; ?>" disabled>      

            <label style="font-size:6" for="">Section</label>
            <input type="text" style="width:100px;text-align:center" value="<?php echo $row['SECTION'] ?>" disabled>
            <br>

            <label style="font-size:6" for="">Total number of years in school to date</label>
            <input type="text" style="width:290px;text-align:center" value="<?php echo $row['TOTAL_NO_OF_YEAR'] ?>" disabled>

            <label style="font-size:6" for="">School Year</label>
            <input type="text" style="width:150px;text-align:center" value="<?php echo $row['SCHOOL_YEAR'] ?>" disabled>
            <br>

            <label style="font-size:6" for="">Adviser:</label>
            <input type="text" style="width:220px;text-align:center" value="<?php echo $row['ADVISER'] ?>" disabled>
            <br><br>

            <div class="col-xs-9" style="width:690px;margin-left:150px;">
                <div class="row">
                    <div class="col-xs-4 text-center" style="height:53px;border:1px solid black;padding-right:1px">
                        <br>
                        <label for="" style="font-size:6">Subjects</label><br>
                    </div>
                    <div class="col-xs-4" style="height:53px;border:1px solid black;width:225px">
                        <label for="" style="font-size:6;text-align:center;width:200px;border-bottom:1px solid black">Periodic Rating</label><br>
                        <label for="" style="font-size:6;width:43px;border-right:1px solid black;text-align:center">1</label>
                        <label for="" style="font-size:6;width:52px;border-right:1px solid black;text-align:center">2</label>
                        <label for="" style="font-size:6;width:52px;border-right:1px solid black;text-align:center">3</label>
                        <label for="" style="font-size:6;width:30px;text-align:center">4</label>
                    </div>
                    <div class="col-xs-1 text-center" style="height:53px;border:1px solid black">
                        <br>
                        <label for="" style="font-size:6">Final</label><br>
                    </div>
                    <div class="col-xs-1 text-center" style="height:53px;border:1px solid black;padding-left:1px;width:100px">
                        <label for="" style="font-size:15px;text-align:center">Passed or Failed</label><br>
                    </div>
                </div>  

                <div class="row">
                    <?php
                    // Assuming $syi is derived from somewhere like student_year_info
                    $syi = $row['SYI_ID']; // Set the correct value for SYI_ID from the previous query result

                    // Fetching subjects based on SYI_ID
                    $sql2 = mysqli_prepare($conn, "SELECT * FROM total_grades_subjects WHERE SYI_ID = ? ORDER BY SUBJECT");
                    if ($sql2) {
                        mysqli_stmt_bind_param($sql2, 'i', $syi);
                        mysqli_stmt_execute($sql2);
                        $result2 = mysqli_stmt_get_result($sql2);

                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $subj = $row2['SUBJECT'];

                            // Fetching subject details
                            $sql3 = mysqli_prepare($conn, "SELECT * FROM subjects WHERE SUBJECT_ID = ?");
                            if ($sql3) {
                                mysqli_stmt_bind_param($sql3, 'i', $subj);
                                mysqli_stmt_execute($sql3);
                                $result3 = mysqli_stmt_get_result($sql3);

                                while ($row3 = mysqli_fetch_assoc($result3)) {
                                    ?>
                                    <div class="col-xs-4" style="border:1px solid black;height:20px">
                                        <?php
                                        if (in_array($row3['SUBJECT'], ["*Music", "*Arts", "*Physical Education", "*Health"])) {
                                            echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $row3['SUBJECT'];
                                        } else {
                                            echo $row3['SUBJECT'];
                                        }
                                        ?>
                                    </div>
                                    <div class="col-xs-4" style="border:1px solid black;width:59px;height:20px;font-size:12px;padding-left:5px;">
                                        <?php echo $row2['1ST_GRADING']; ?>
                                    </div> 
                                    <div class="col-xs-4" style="border:1px solid black;width:56px;height:20px;font-size:12px;padding-left:5px;">
                                        <?php echo $row2['2ND_GRADING']; ?>
                                    </div> 
                                    <div class="col-xs-4" style="border:1px solid black;width:56px;height:20px;font-size:12px;padding-left:5px;">
                                        <?php echo $row2['3RD_GRADING']; ?>
                                    </div> 
                                    <div class="col-xs-4" style="border:1px solid black;width:54px;height:20px;font-size:12px;padding-left:5px;">
                                        <?php echo $row2['4TH_GRADING']; ?>
                                    </div>    
                                    <div class="col-xs-1 text-center" style="font-size:12px;border:1px solid black;height:20px;padding-left:1px">
                                        <?php echo $row2['FINAL_GRADES']; ?>
                                    </div>
                                    <div class="col-xs-1 text-center" style="border:1px solid black;height:20px;padding-left:2px;text-align:center;font-size:12px;width:100px">
                                        <?php echo $row2['PASSED_FAILED']; ?>
                                    </div>
                                    <?php
                                }
                                mysqli_stmt_close($sql3); // Close sql3 after use
                            }
                        }
                        mysqli_stmt_close($sql2); // Close sql2 after use
                    }
                    ?>
                </div>
            </div>

            <div class="col-xs-12">
                <br><br>
                <table class="table" style="width:940px">
                    <tr>
                        <th style="font-size:10px;text-align:center;width:130px;border:1px solid black">Months</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Jun</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Jul</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Aug</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Sept</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Oct</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Nov</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Dec</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Jan</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">Feb</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">March</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">April</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:50px">May</th>
                        <th style="font-size:10px;border:1px solid black;text-align:center;width:130px">Total</th>
                    </tr>
                    <tr>
                        <td style="font-size:10px;text-align:center;width:130px">Days of School</td>
                        <?php
                        // Fetch attendance data only once
                        $atten = mysqli_prepare($conn, "SELECT * FROM attendance WHERE SYI_ID = ? ORDER BY ATT_ID");
                        mysqli_stmt_bind_param($atten, 'i', $syi);
                        mysqli_stmt_execute($atten);
                        $resultAtten = mysqli_stmt_get_result($atten);

                        while ($att = mysqli_fetch_assoc($resultAtten)) {
                            ?>
                            <td style="font-size:10px;text-align:center;width:50px"><?php echo $att['DAYS_OF_CLASSES']; ?></td>
                            <?php
                        }
                        ?>
                        <td style="font-size:10px;text-align:center;width:130px"><?php echo $row['TDAYS_OF_CLASSES']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size:10px;text-align:center;width:130px">Days Present</td>
                        <?php
                        // Fetch attendance data for days present
                        $atten2 = mysqli_prepare($conn, "SELECT * FROM attendance WHERE SYI_ID = ? ORDER BY ATT_ID");
                        mysqli_stmt_bind_param($atten2, 'i', $syi);
                        mysqli_stmt_execute($atten2);
                        $resultAtten2 = mysqli_stmt_get_result($atten2);

                        while ($att2 = mysqli_fetch_assoc($resultAtten2)) {
                            ?>
                            <td style="font-size:10px;text-align:center;width:50px"><?php echo $att2['DAYS_PRESENT']; ?></td>
                            <?php
                        }
                        ?>
                        <td style="font-size:10px;text-align:center;width:130px"><?php echo $row['TDAYS_PRESENT']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <br><br>
        <input type="text" style="width:100%;text-align:center" disabled>
        <br><br>
        <?php
    }

    // Close all remaining prepared statements
    mysqli_stmt_close($sql);

    // Close the database connection
    mysqli_close($conn);
}
?>
