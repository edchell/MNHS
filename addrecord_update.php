<?php
include 'db.php';
  $sql=  mysqli_query($conn, "SELECT * FROM student_info where STUDENT_ID = '".$_GET['id']."' ");
    while($row = mysqli_fetch_assoc($sql)) {
?>
  <h1 class="page-header"><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></h1>
    <?php
      } mysqli_close($conn);
    ?>

<!-- School -->
<input name="id" type="hidden" value="<?php echo $_GET["id"] ?>">
  <div class="col-md-6">
    <div class="row">
      <label class="col-md-4 te" for="school">School</label>
        <div class="col-md-6">
          <?php
            include 'db.php'; 
              $id = $_GET['id'];
              $id = mysqli_real_escape_string($conn, $id);
              $sql = "SELECT * 
                      FROM student_year_info 
                      LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
                      LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
                      WHERE STUDENT_ID = '$id'";
              $result = mysqli_query($conn, $sql);
                if ($row = mysqli_fetch_assoc($result)) {
                  $syi = $row['SYI_ID'];
                    $sql1 = "SELECT * FROM student_info WHERE STUDENT_ID = '$id'";
                      $result1 = mysqli_query($conn, $sql1);
                        if ($row1 = mysqli_fetch_assoc($result1)) {
                          $sql3 = "SELECT * FROM program WHERE PROGRAM_ID = '".$row1['PROGRAM']."'";
                            $result3 = mysqli_query($conn, $sql3);
                              if ($row2 = mysqli_fetch_assoc($result3)) {
          ?>
              <input type="text" name="school" class="form-control" id ="school" value="<?php echo htmlspecialchars($row['SCHOOL']); ?>" readonly required>
          <?php
                }
              }
            }
          ?>
        </div>
    </div>
<br>
    <!-- Grade -->
    <div class="row">
      <label class="col-md-4 te" for="yr">Grade</label>
        <div class="col-md-6">
          <?php
            include 'db.php'; 
              $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);
                  $sql = "SELECT * 
                          FROM student_year_info 
                          LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
                          LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
                          WHERE STUDENT_ID = '$id'";
                  $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                      $syi = $row['SYI_ID'];
                        $sql1 = "SELECT * FROM student_info WHERE STUDENT_ID = '$id'";
                          $result1 = mysqli_query($conn, $sql1);
                            if ($row1 = mysqli_fetch_assoc($result1)) {
                              $sql3 = "SELECT * FROM program WHERE PROGRAM_ID = '".$row1['PROGRAM']."'";
                                $result3 = mysqli_query($conn, $sql3);
                                  if ($row2 = mysqli_fetch_assoc($result3)) {
          ?>
            <input type="text" name="grade" class="form-control" id ="grade" value="<?php echo htmlspecialchars($row['TO_BE_CLASSIFIED']); ?>" readonly required>
          <?php
                }
              }
            }
          ?>
        </div>
    </div>
<br>
    <!-- Section -->
    <div class="row">
      <label class="col-md-4 te" for="sec">Section</label>
        <div class="col-md-6">
          <?php
            include 'db.php'; 
              $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);
                  $sql = "SELECT * 
                          FROM student_year_info 
                          LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
                          LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
                          WHERE STUDENT_ID = '$id'";
                  $result = mysqli_query($conn, $sql);
                    if ($row = mysqli_fetch_assoc($result)) {
                      $syi = $row['SYI_ID'];
                        $sql1 = "SELECT * FROM student_info WHERE STUDENT_ID = '$id'";
                          $result1 = mysqli_query($conn, $sql1);
                            if ($row1 = mysqli_fetch_assoc($result1)) {
                              $sql3 = "SELECT * FROM program WHERE PROGRAM_ID = '".$row1['PROGRAM']."'";
                                $result3 = mysqli_query($conn, $sql3);
                                  if ($row2 = mysqli_fetch_assoc($result3)) {
          ?>
            <input type="text" name="sec" class="form-control" value="<?php echo htmlspecialchars($row['SECTION']); ?>" readonly id ="sec"required>
          <?php
                }
              }
            }
          ?>
        </div>
    </div>
<br>
    <!-- Total no. of yrs -->
    <div class="row">
      <label class="col-md-4 te" for="tny">Total no. of yrs</label>
        <div class="col-md-6">
          <?php 
            include 'db.php';
              $tquery = mysqli_query($conn,"SELECT * from student_year_info where STUDENT_ID = '".$_GET['id']."' group by TOTAL_NO_OF_YEAR order by TOTAL_NO_OF_YEAR DESC limit 1");
              $tcount = mysqli_num_rows($tquery);
              $trow=mysqli_fetch_assoc($tquery);
              if($tcount < 1){
                $squery = mysqli_query($conn,"SELECT * from student_info where STUDENT_ID = '".$_GET['id']."'");
                $srow=mysqli_fetch_assoc($squery);
          ?>
            <input type="text" name="tny" class="form-control" id ="" value="<?php echo $srow['TOTAL_NO_OF_YEARS']+1 ?>" readonly>
          <?php }else{ ?>
            <input type="text" name="tny" class="form-control" id ="" value="<?php echo $trow['TOTAL_NO_OF_YEAR']+1 ?>" readonly>
          <?php
            } 
          ?>
        </div>
    </div>
<br>
    <!-- School Year -->
    <div class="row">
      <label class="col-md-4 te" for="sy">School Year</label>
        <div class="col-md-6">
          <input type="text" name="sy" class="form-control" id ="sy" readonly value="<?php echo $_GET['sy'] ?>"  >
        </div>
    </div>
  </div>
  <div class="col-md-6">
    <div id="en_adv">
      <!-- Adviser -->
      <div class="row">
        <label class="col-md-2 te" for="adviser">Adviser</label>
          <div class="col-md-6">
            <?php
              include 'db.php'; 
                $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);
                $sql = "SELECT * 
                        FROM student_year_info 
                        LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
                        LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
                        WHERE STUDENT_ID = '$id'";
                $result = mysqli_query($conn, $sql);
                  if ($row = mysqli_fetch_assoc($result)) {
                    $syi = $row['SYI_ID'];
                      $sql1 = "SELECT * FROM student_info WHERE STUDENT_ID = '$id'";
                      $result1 = mysqli_query($conn, $sql1);
                        if ($row1 = mysqli_fetch_assoc($result1)) {
                          $sql3 = "SELECT * FROM program WHERE PROGRAM_ID = '".$row1['PROGRAM']."'";
                          $result3 = mysqli_query($conn, $sql3);
                            if ($row2 = mysqli_fetch_assoc($result3)) {
            ?>
              <input type="text" name="adviser" class="form-control" value="<?php echo htmlspecialchars($row['ADVISER']); ?>" readonly id ="adviser" >
            <?php
                  }
                }
              }
            ?>
        </div>
      </div>
    </div>
<br>
      <!-- Rank -->
      <div class="row">
        <label class="col-md-2 te" for="ra">Rank</label>
          <div class="col-md-6">
            <?php
              include 'db.php'; 
                $id = $_GET['id'];
                $id = mysqli_real_escape_string($conn, $id);
                $sql = "SELECT * 
                        FROM student_year_info 
                        LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
                        LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
                        WHERE STUDENT_ID = '$id'";
                $result = mysqli_query($conn, $sql);
                if ($row = mysqli_fetch_assoc($result)) {
                  $syi = $row['SYI_ID'];
                  $sql1 = "SELECT * FROM student_info WHERE STUDENT_ID = '$id'";
                  $result1 = mysqli_query($conn, $sql1);
                  if ($row1 = mysqli_fetch_assoc($result1)) {
                    $sql3 = "SELECT * FROM program WHERE PROGRAM_ID = '".$row1['PROGRAM']."'";
                    $result3 = mysqli_query($conn, $sql3);
                    if ($row2 = mysqli_fetch_assoc($result3)) {
            ?>
              <input type="text" name="rank" class="form-control" id ="ra" readonly value="<?php echo htmlspecialchars($row['RANK']); ?>">
            <?php
                  }
                }
              }
            ?>
          </div>
      </div>
<br>
</div>
<div class="mt-5">
<br>
<br>
<!-- Grades Table -->
<form action="" method="post">
    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width:140px;text-align:center">Subject</th>
                <th style="width:50px;text-align:center">1</th>
                <th style="width:50px;text-align:center">2</th>
                <th style="width:50px;text-align:center">3</th>
                <th style="width:50px;text-align:center">4</th>
                <th style="width:60px;text-align:center">Final</th>
                <th style="width:120px;text-align:center">Passed<br>or<br>Failed</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch subjects and grades
            $check_query = "SELECT * FROM total_grades_subjects WHERE SYI_ID = '$syi' GROUP BY SUBJECT";
            $check_query_result = mysqli_query($conn, $check_query);
            if ($check_query_result) {
                while ($check = mysqli_fetch_assoc($check_query_result)) {
                    $sub = $check['SUBJECT'];
                    $check1 = mysqli_query($conn, "SELECT * FROM subjects WHERE SUBJECT_ID = '$sub'");
                    while ($check2 = mysqli_fetch_assoc($check1)) {
            ?>
            <tr>
                <td><input type="text" style="text-align:center;" name="subject[]" value="<?php echo htmlspecialchars($check2['SUBJECT']); ?>" readonly></td>
                <td><input style="width:50px;text-align:center;" value="<?php echo htmlspecialchars($check['1ST_GRADING']); ?>" class="grade" type="text" name="1st[]"></td>
                <td><input style="width:50px;text-align:center;" value="<?php echo htmlspecialchars($check['2ND_GRADING']); ?>" class="grade" type="text" name="2nd[]"></td>
                <td><input style="width:50px;text-align:center;" value="<?php echo htmlspecialchars($check['3RD_GRADING']); ?>" class="grade" type="text" name="3rd[]"></td>
                <td><input style="width:50px;text-align:center;" value="<?php echo htmlspecialchars($check['4TH_GRADING']); ?>" class="grade" type="text" name="4th[]"></td>
                <td><input style="width:60px;text-align:center;" id="fin" type="number" value="<?php echo htmlspecialchars($check['FINAL_GRADES']); ?>" name="final[]" readonly=""></td>
                <td><input type="text" name="action[]" id="action" style="text-align:center" value="<?php echo htmlspecialchars($check['PASSED_FAILED']); ?>" readonly=""></td>
                <input type="hidden" name="subject_id[]" value="<?php echo htmlspecialchars($check['SUBJECT_ID']); ?>"> <!-- Assuming SUBJECT_ID is the unique identifier -->
            </tr>
            <?php
                    }
                }
            } else {
                echo "<tr><td colspan='7'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div class="mt-2">
    <br>
    <button class="btn btn-success" type="submit">Save</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through submitted grades and update database
    $subjects = $_POST['subject_id'];
    $first_grading = $_POST['1st'];
    $second_grading = $_POST['2nd'];
    $third_grading = $_POST['3rd'];
    $fourth_grading = $_POST['4th'];
    $final_grades = $_POST['final'];
    $action = $_POST['action'];

    for ($i = 0; $i < count($subjects); $i++) {
        $subject_id = mysqli_real_escape_string($conn, $subjects[$i]);
        $first = mysqli_real_escape_string($conn, $first_grading[$i]);
        $second = mysqli_real_escape_string($conn, $second_grading[$i]);
        $third = mysqli_real_escape_string($conn, $third_grading[$i]);
        $fourth = mysqli_real_escape_string($conn, $fourth_grading[$i]);
        $final = mysqli_real_escape_string($conn, $final_grades[$i]);
        $status = mysqli_real_escape_string($conn, $action[$i]);

        $update_query = "UPDATE total_grades_subjects 
                         SET 1ST_GRADING = '$first', 
                             2ND_GRADING = '$second', 
                             3RD_GRADING = '$third', 
                             4TH_GRADING = '$fourth', 
                             FINAL_GRADES = '$final', 
                             PASSED_FAILED = '$status' 
                         WHERE SUBJECT_ID = '$subject_id' AND SYI_ID = '$syi'";

        mysqli_query($conn, $update_query);
    }

    // Check for errors
    if (mysqli_error($conn)) {
        echo "Error updating grades: " . mysqli_error($conn);
    } else {
        echo "Grades updated successfully!";
    }
}
?>
  <button onclick="window.history.back()" style="
    background-color: #6c757d; /* Custom gray background */
    color: white; /* White text */
    padding: 5px 10px; /* Padding around text */
    font-size: 16px; /* Font size */
    border: none; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s; /* Smooth transition on hover */
    ">Back</button>
</div>
  </div>
    <script>
      $(document).ready(function() {
    
    calculateSum();
     calculateAVE();
     acts();


    $(".dc").on("keydown keyup", function() {
        calculateSum();
    });
    $(".p").on("keydown keyup", function() {
        calculateAVE();
    });
    $("#action").on("keydown keyup", function() {
        acts();
    });
});

function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".dc").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
            ;
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
  $("input#tdc").val(sum.toFixed(0));
}

function calculateSum2($i) {
    var sum = 0,
    i = $i;
    //iterate through each textboxes and add the values
    $(".grade"+ i).each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value)/ "4";
            $(this).css("background-color", "white");
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "rgba(255, 0, 0, 0.49)");
        }
        if(this.value > 100){
          $(this).css("background-color", "rgba(255, 0, 0, 0.49)");
        }else{
            $(this).css("background-color", "white");
          
        }
    });
 if(sum < 75){
  $("input#action"+ i).val("FAILED");
 }else{
  $("input#action"+ i).val("PASSED");

 }
  $("input#fin"+i).val(sum.toFixed(2));
}
function calculateAVE() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $("input.p").each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value) ;
            ;
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 
  $("input#tp").val(sum.toFixed(0));
}
function acts($i){
  var i = $i;
 $("input#action"+i).each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value == 'FAILED') {
             $("input#stats").val('Retained');
        }
        else{
           $("input#stats").val('Promoted');
        }
    });
  
 }

 function validate(i){
    if($("#p"+i).val() > $("#dc"+i).val()){
      $("#p"+i).css("background-color","rgba(255, 0, 0, 0.49)");
    }else{
      $("#p"+i).css("background-color","white");
    }
  }

  $(document).ready(function() {
    // Calculate final grades on input change
    $(".grade").on("input", function() {
        calculateFinalGrades();
    });

    // Initial calculation for existing grades
    calculateFinalGrades();
});

function calculateFinalGrades() {
    $("tbody tr").each(function() {
        var sum = 0;
        var count = 0;
        
        // Get all grading inputs in the current row
        $(this).find("input[name='1st[]'], input[name='2nd[]'], input[name='3rd[]'], input[name='4th[]']").each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                sum += value;
                count++;
            }
        });

        // Calculate the final grade if there are valid grades
        if (count > 0) {
            var finalGrade = sum / count;
            $(this).find("input[name='final[]']").val(finalGrade.toFixed(2));

            // Update Passed/Failed status
            var actionInput = $(this).find("input[name='action[]']");
            if (finalGrade < 75) {
                actionInput.val("FAILED");
            } else {
                actionInput.val("PASSED");
            }
        } else {
            $(this).find("input[name='final[]']").val(""); // Clear final if no grades
            $(this).find("input[name='action[]']").val(""); // Clear action if no grades
        }
    });
}

    </script>
 
 