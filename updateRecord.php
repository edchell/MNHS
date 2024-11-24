<?php
session_start();
if (isset($_GET['id']) && isset($_GET['gradeid'])) {  // Checking if both 'id' and 'gradeid' are set in the URL
    include 'db.php';  // Including the database connection file

    // Using mysqli_real_escape_string to sanitize the inputs (good practice)
    $req = mysqli_real_escape_string($conn, $_GET['gradeid']);
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch the grade from the 'grade' table based on the provided 'gradeid'
    $grade_sql = mysqli_query($conn, "SELECT grade FROM grade WHERE grade_id = '$req'");
    while ($grade = mysqli_fetch_assoc($grade_sql)) {
        $grade_id = $grade['grade'];  // Extracting the grade value
    }

    // Query to fetch student details from 'student_year_info' based on the student's 'id' and 'grade_id'
    $sql = mysqli_query($conn, "SELECT * FROM student_year_info 
        LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id 
        LEFT JOIN advisers ON student_year_info.ADVISER = advisers.adviser_id 
        WHERE STUDENT_ID = '$id' AND YEAR = '$req'");

    $NUM = mysqli_num_rows($sql);  // Checking if any rows were returned
    if ($NUM > 0) {  // If rows were found, process the result
        while ($row = mysqli_fetch_assoc($sql)) {
            $syi = $row['SYI_ID'];  // Extracting the 'SYI_ID' value for use later

?>
<script src="assets/js/ie-emulation-modes-warning.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</style>
<a href="rms.php?page=record&id=<?php echo $id ?>" class="btn btn-primary" style="margin-top:20px;margin-left:20px;margin-bottom:10px;">BACK</a> 
<br>
<br>
    <form method="POST" action="uprec.php">
    <input type="hidden" name="syi" value="<?php echo $row["SYI_ID"] ?>" >
    <input type="hidden" name="id" value="<?php echo $row1['STUDENT_ID'] ?>" >
      <label style="font-size:6;margin-left:10%;" for="">School</label>
        <input type="text" name="school" style="width:450px;text-align:center" value="<?php echo $row["SCHOOL"] ?>" readonly>

      <label style="font-size:6" for="">Grade</label>
      <input type="text" name="yr" value="<?php echo $row["grade"] ?>" style="width:100px;text-align:center;border:0px solid white;border-bottom:1px solid black" readonly>    

      <label style="font-size:6" for="">Section</label>
        <input type="text" name="sec" style="width:100px;text-align:center" value="<?php echo $row["SECTION"] ?>" readonly>  
        <br>

      <label style="font-size:6;margin-left:10%;" for="">Total number of years in school to date</label>
        <input type="text" name="tny" style="width:290px;text-align:center" value="<?php echo $row["TOTAL_NO_OF_YEAR"] ?>" readonly>

      <label style="font-size:6" for="">School Year</label>
        <input type="text" name="sy" style="width:150px;text-align:center" value="<?php echo $row["SCHOOL_YEAR"] ?>" readonly>
<br>
        <label style="font-size:6;margin-left:10%;" for="">Adviser:</label>
        <input type="text" name="adviser" style="width:220px;text-align:center" 
        value="<?php echo $row['ADVISER'] ?>" required>

    
        <br><br><br>

        <div class="col-xs-9" style="width:700px;margin-left:150px;">

        <div class="row" style="margin-left:10%" >
          <div class="col-xs-4 text-center" style="height:53px;border:1px solid black;padding-right:1px">
          <br>
            <label for="" style="font-size:6">Subjects</label>
            <br>
          </div>
          <div class="col-xs-4" style="height:53px;border:1px solid black;width:225px">
          
            <label for="" style="font-size:6;text-align:center;width:200px;border-bottom:1px solid black">Periodic Rating</label>
            <br>
            <label for="" style="font-size:6;width:43px;border-right:1px solid black;text-align:center">1</label>
            <label for="" style="font-size:6;width:52px;border-right:1px solid black;text-align:center">2</label>
            <label for="" style="font-size:6;width:52px;border-right:1px solid black;text-align:center">3</label>
            <label for="" style="font-size:6;width:30px;;text-align:center">4</label>
          </div>
          <div class="col-xs-1 text-center" style="height:53px;border:1px solid black">
          <br>
            <label for="" style="font-size:6">Final</label>
            <br>
          </div>
          <div class="col-xs-1 text-center" style="height:53px;border:1px solid black;padding-left:1px;width:100px">
          
            <label for="" style="font-size:15px">Passed or Failed</label>
            <br>
          </div>

            

        </div>  
         

      
        <div class="row" id="t_row" style="margin-left:10%">
   <?php     $sql2=  mysqli_query($conn, "SELECT * FROM total_grades_subjects where SYI_ID = '$syi' order by SUBJECT ");
    while($row2 = mysqli_fetch_assoc($sql2)){
      $subj =  $row2['SUBJECT'];

         $sql3=  mysqli_query($conn, "SELECT * FROM subjects where SUBJECT_ID = '$subj' ");
    while($row3 = mysqli_fetch_assoc($sql3)){


      ?>
          <div class="col-xs-4" style="border:1px solid black;height:25px">
    <input type="hidden" name="tg_id[]" value="<?php echo htmlspecialchars($row2['TGS_ID']); ?>" >
    <select name="subj[]">
        <option value="<?php echo htmlspecialchars($subj); ?>"> <?php echo htmlspecialchars($row3['SUBJECT']); ?> </option>
        <?php
        $sql4 = mysqli_query($conn, "SELECT * FROM subjects WHERE SUBJECT_ID != '".$row2['SUBJECT']."' ORDER BY SUBJECT_ID");
        while ($row4 = mysqli_fetch_assoc($sql4)) {
        ?>
            <option value="<?php echo htmlspecialchars($row4['SUBJECT_ID']); ?>"> <?php echo htmlspecialchars($row4['SUBJECT']); ?></option>
        <?php
        }
        ?>
    </select>
</div>
          
          <div class="col-xs-4" style="border:1px solid black;width:59px;height:25px;font-size:12px;    padding-left: 5px;">
          <input type="text" style="border-bottom:0px" name="1st[]" value="<?php echo $row2['1ST_GRADING'] ?>"  onkeyup="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" onkeydown="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" class="grade<?php echo $row2['TGS_ID'] ?>" oninput="validateNumber(event)" maxlength="3" required>
           
        </div> 
        <div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px;    padding-left: 5px;">
         <input type="text" style="border-bottom:0px" name="2nd[]" value="<?php echo $row2['2ND_GRADING'] ?>"  onkeyup="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" onkeydown="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" class="grade<?php echo $row2['TGS_ID'] ?>" oninput="validateNumber(event)" maxlength="3" required>       
          </div> 
        <div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px;    padding-left: 5px;">
        <input type="text" style="border-bottom:0px" name="3rd[]" value="<?php echo $row2['3RD_GRADING'] ?>"  onkeyup="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" onkeydown="calculateSum2(<?php echo $row2['TGS_ID']?>)" class="grade<?php echo $row2['TGS_ID'] ?>" oninput="validateNumber(event)" maxlength="3" required>
         
        </div> 
        <div class="col-xs-4" style="border:1px solid black;width:54px;height:25px;font-size:12px;    padding-left: 5px;" >
        <input type="text" style="border-bottom:0px" name="4th[]" value="<?php echo $row2['4TH_GRADING'] ?>"  onkeyup="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" onkeydown="calculateSum2(<?php echo $row2['TGS_ID'] ?>)" class="grade<?php echo $row2['TGS_ID'] ?>" oninput="validateNumber(event)" maxlength="3" required>
        </div>    
        <div class="col-xs-1 text-center" style="font-size:12px;border:1px solid black;height:25px;padding-left:1px">
        <input type="text" style="border-bottom:0px" name="final[]" value="<?php echo $row2['FINAL_GRADES'] ?>" id="fin<?php echo $row2['TGS_ID'] ?>" readonly>
        </div>
        <div class="col-xs-1 text-center" style="border:1px solid black;height:25px;    padding-left: 2px;text-align:center;font-size:12px;width:100px">
      <input style="border-bottom:0px" type="text" name="action[]" value="<?php echo $row2['PASSED_FAILED'] ?>" id="action<?php echo $row2['TGS_ID'] ?>" readonly>
          
        </div>

        <?php
      }
    }
    
         ?>

    <br>
    <div id="t_rows">
    <?php
for ($i = 0; $i < 1; $i++) {
?>
<div id="new_row" class="tr<?php echo $i ?>">
    <div class="col-xs-4" style="border:1px solid black;height:25px">
        <select name="sub[]" onchange="handleSubjectChange()" required>
            <option></option>
            <?php
            $sql4 = mysqli_query($conn, "SELECT * from SUBJECTS");
            while ($row4 = mysqli_fetch_assoc($sql4)) {
            ?>
                <option value="<?php echo $row4['SUBJECT_ID']; ?>"><?php echo $row4['SUBJECT']; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    
    <div class="col-xs-4" style="border:1px solid black;width:59px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="una[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="duwa[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-4" style="border:1px solid black;width:56px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="tatlo[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-4" style="border:1px solid black;width:54px;height:25px;font-size:12px; padding-left:5px;">
        <input type="text" style="border-bottom:0px" name="apat[]" onkeyup="ave2(<?php echo $i ?>)" onkeydown="ave2(<?php echo $i ?>)" class="grad<?php echo $i ?>" oninput="validateNumber(event)" required>
    </div>
    <div class="col-xs-1 text-center" style="font-size:12px;border:1px solid black;height:25px;padding-left:1px">
        <input type="text" style="border-bottom:0px" name="fin[]" id="fina<?php echo $i ?>" readonly>
    </div>
    <div class="col-xs-1 text-center" style="border:1px solid black;height:25px; padding-left:2px;text-align:center;font-size:12px;width:100px">
        <input style="border-bottom:0px" type="text" name="act[]" id="act<?php echo $i ?>" readonly>
    </div>
</div>
<?php } ?>

<script>
    function validateNumber(event) {
    const input = event.target;
    input.value = input.value.replace(/[^0-9]/g, ''); // Remove anything that's not a number
}
</script>
   </div>
    </div>
    </div> 

   
       
    </div>


    <div class="col-xs-12">
      <br>
      <table class="table" style="width:940px;margin-left:7%">
  <tr>
    <th style="font-size:10px;text-align:center;width:130px">Months</th>
    <th style="font-size:10px;text-align:center;width:50px">Jun</th>
    <th style="font-size:10px;text-align:center;width:50px">Jul</th>
    <th style="font-size:10px;text-align:center;width:50px">Aug</th>
    <th style="font-size:10px;text-align:center;width:50px">Sept</th>
    <th style="font-size:10px;text-align:center;width:50px">Oct</th>
    <th style="font-size:10px;text-align:center;width:50px">Nov</th>
    <th style="font-size:10px;text-align:center;width:50px">Dec</th>
    <th style="font-size:10px;text-align:center;width:50px">Jan</th>
    <th style="font-size:10px;text-align:center;width:50px">Feb</th>
    <th style="font-size:10px;text-align:center;width:50px">March</th>
    <th style="font-size:10px;text-align:center;width:50px">April</th>
    <th style="font-size:10px;text-align:center;width:50px">May</th>
    <th style="font-size:10px;text-align:center;width:130px">Total</th>
  </tr>

  <tr>
    <td style="font-size:10px;text-align:center;width:130px">Days of School</td>
    <?php
    $atten = mysqli_query($conn, "SELECT * FROM attendance where SYI_ID = '$syi' order by ATT_ID ");
    while($att = mysqli_fetch_assoc($atten)) {
    ?>
    <td style="font-size:10px;text-align:center;width:50px">
      <input type="hidden" name="att_id[]" value="<?php echo $att['ATT_ID'] ?>" >
      <input style="border-bottom:0px;width:30px" class="dc" type="text" name="dc[]" value="<?php echo $att['DAYS_OF_CLASSES'] ?>" oninput="calculateTotal()" maxlength="2" required>
    </td>
    <?php } ?>
    <td style="font-size:10px;text-align:center;width:130px">
      <input id="tdc" type="text" name="Tdc" style="text-align:center;width:100px;border-bottom:0px" readonly>
    </td>
  </tr>

  <tr>
    <td style="font-size:10px;text-align:center;width:130px">Days Present</td>
    <?php
    $atten2 = mysqli_query($conn, "SELECT * FROM attendance where SYI_ID = '$syi' order by ATT_ID ");
    while($att2 = mysqli_fetch_assoc($atten2)) {
    ?>
    <td style="font-size:10px;text-align:center;width:50px">
      <input type="hidden" name="att_d[]" value="<?php echo $att2['ATT_ID'] ?>" >
      <input style="border-bottom:0px;width:30px" class="p" type="text" name="pp[]" value="<?php echo $att2['DAYS_PRESENT'] ?>" oninput="calculateTotal()" maxlength="2" required>
    </td>
    <?php } ?>
    <td style="font-size:10px;text-align:center;width:130px">
      <input type="text" id="tp" name="Tp" style="text-align:center;width:100px;border-bottom:0px" readonly>
    </td>
  </tr>

</table>

      <button type="submit" style="margin-left:80%" class="btn btn-success">Update</button>
      <a id="new_add" style="margin-top:5px;margin-bottom:5px;" class="btn btn-primary"><i class="fa fa-plus"></i>Add row</a>
    </form>
    </div>
       </div>
    </div>
 </div>
    </div>
    <br>
        <?php

            }  
          }
          else{
            echo "<br><br><br>";
            echo "<h3>This student does not have record in selected grade.</h3>";
          }
          mysqli_close($conn);
          }
     ?> 
     <script>
      $(document).ready(function() {
    //this calculates values automatically 
    calculateSum();
     calculateSum2();
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
            ;
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 if(sum < 75){
  $("input#action"+ i).val("FAILED");
 }else{
  $("input#action"+ i).val("PASSED");

 }
  $("input#fin"+i).val(sum);
}
function ave2($i) {
    var sum = 0,
    i = $i;
    //iterate through each textboxes and add the values
    $(".grad"+ i).each(function() {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value)/ "4";
            ;
        }
        else if (this.value.length != 0){
            $(this).css("background-color", "red");
        }
    });
 if(sum < 75){
  $("input#act"+ i).val("FAILED");
 }else{
  $("input#act"+ i).val("PASSED");

 }
  $("input#fina"+i).val(sum);
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

function validateNumber(event) {
    const input = event.target;
    input.value = input.value.replace(/[^0-9]/g, ''); // Remove anything that's not a number
}

    </script>