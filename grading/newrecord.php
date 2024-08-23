 	<?php

include 'db.php';

$id = $_POST['id'];
$school = $_POST['school'];
$yr = $_POST['yr'];
$sec = $_POST['sec'];
$tny = $_POST['tny'];
$sy = $_POST['sy'];
$au = $_POST['au'];
$lu = $_POST['lu'];
$adv= $_POST['adviser'];
$tbca = $_POST['class'];
$rank = $_POST['rank'];
$subject = $_POST['subj'];
$una = $_POST['1st'];
$ikaduwa = $_POST['2nd'];
$ikatlo = $_POST['3rd'];
$ikaapat = $_POST['4th'];
$u = $_POST['units'];
$f = $_POST['final'];
$a = $_POST['action'];
$month = $_POST['month'];
$dc = $_POST['dc'];
$p = $_POST['p'];
$Tdc = $_POST['Tdc'];
$Tp = $_POST['Tp'];
$user = $_SESSION['ID'];

$search_qry = mysqli_query($conn, "SELECT * from student_year_info left join student_info on student_year_info.STUDENT_ID = student_info.STUDENT_ID WHERE STUDENT_ID = '$id' AND YEAR ='$yr' ");
$row = mysqli_query['search_qry'];
$student = $row['FIRSTNAME'] .' '. $row['LASTNAME'];
$num_row = mysqli_num_rows($search_qry);
		if($num_row >= 1){
			echo "<script>
			alert('Student Year Record is already Exist!');
			 location.replace(document.referrer);
			</script>";
			
		}else{

		$sql= mysqli_query($conn,"INSERT INTO student_year_info
			 (STUDENT_ID, SCHOOL, YEAR, SECTION, TOTAL_NO_OF_YEAR, SCHOOL_YEAR, ADVANCE_UNIT, LACK_UNIT, ADVISER,  RANK, TO_BE_CLASSIFIED, TDAYS_OF_CLASSES, TDAYS_PRESENT,ACTION)
			 VALUES('$id','$school', '$yr', '$sec', '$tny', '$sy', '$au', '$lu', '$adv',  '$rank', '$tbca', '$Tdc', '$Tp','Promoted' ) ");
			$last_id = mysqli_insert_id($conn);
			$sc= count($subject);
			mysqli_query($conn, "INSERT into history_log (transaction,user_id,date_added) 
		VALUES ('added record of $student','$user',NOW() )");


			for($w=0;$w < $sc;$w++){
				if($subject[$w] != ''){
				mysqli_query($conn,"INSERT INTO total_grades_subjects (STUDENT_ID, SYI_ID, SUBJECT, 1ST_GRADING, 2ND_GRADING, 3RD_GRADING, 4TH_GRADING, UNITS, FINAL_GRADES, PASSED_FAILED)
				VALUES('$id', '$last_id', '$subject[$w]', '$una[$w]', '$ikaduwa[$w]', '$ikatlo[$w]', '$ikaapat[$w]', '$u[$w]', '$f[$w]', '$a[$w]')");
			}
			}
			
		

		$mc = count($month);

		for($i=0 ; $i < $mc; $i++)
		{
			mysqli_multi_query($conn,"INSERT INTO attendance (STUDENT_ID, SYI_ID, MONTH, DAYS_OF_CLASSES, DAYS_PRESENT)
				VALUES('$id', '$last_id', '$month[$i]', '$dc[$i]', '$p[$i]')");
		}

		$query = mysqli_query($conn,"SELECT *,COUNT(TGS_ID) as tg_count, SUM(FINAL_GRADES)as fin_grade FROM total_grades_subjects WHERE SYI_ID = '$last_id' ");
		while($row=mysqli_fetch_assoc($query)){
			$ga = $row['fin_grade'] / $row['tg_count'];
			mysqli_query($conn,"UPDATE student_year_info SET GEN_AVE = '$ga' WHERE SYI_ID = '".$row['SYI_ID']."' ");
		}

		$query2 = mysqli_query($conn,"SELECT * FROM total_grades_subjects WHERE SYI_ID = '$last_id' AND PASSED_FAILED='FAILED' ");
		while($row2=mysqli_fetch_assoc($query2)){
			
			$counts =  mysqli_num_rows($query2);
			$query3 = mysqli_query($conn,"SELECT * FROM grade WHERE grade_id = '$yr'");
			$row3=mysqli_fetch_assoc($query3);
			$tbca2 = $row3['grade'];
			
			if($counts > 2){
			mysqli_query($conn,"UPDATE student_year_info SET ACTION = 'Retained',TO_BE_CLASSIFIED='$tbca2' WHERE SYI_ID = '".$row2['SYI_ID']."' "); 
			}
			else{
			mysqli_query($conn,"UPDATE student_year_info SET ACTION = 'Conditional(Promoted)',TO_BE_CLASSIFIED='$tbca2' WHERE SYI_ID = '".$row2['SYI_ID']."' "); 
			}
		}
			 
			
			header('location:rms.php?page=record&id='.$id);

		}
		mysqli_close($conn);


?>
 </table>
      <!-- <div class="btn btn-success" id="addnew">Add</div>-->
       </div>
       <div class="col-md-3">
        <br>
         <br>
       <table class="table-bordered">
         <thead>
           <tr class="text-center">
             <td>Months</td>
             <td>Days of Classes</td>
             <td>Days Present</td>
           </tr>
         </thead>
         <tbody>
           <tr>
             <td><input type="text" name="month[]" value="June" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc1" style="text-align:center;width:100px" ></td>
             <td><input type="text" class="p" name="p[]" id="p1" onkeyup="validate('1')" onkeydown="validate('1')" style="text-align:center;width:100px" ></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="July" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc2" style="text-align:center;width:100px" ></td>
             <td><input type="text" class="p" name="p[]" id="p2" onkeyup="validate('2')" onkeydown="validate('2')" style="text-align:center;width:100px" ></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="August" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc3" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p3" onkeyup="validate('3')" onkeydown="validate('3')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="September" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc4" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p4" onkeyup="validate('4')" onkeydown="validate('4')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="October" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc5" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p5" onkeyup="validate('5')" onkeydown="validate('5')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="November" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc6" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p6" onkeyup="validate('6')" onkeydown="validate('6')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="December" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc7" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p7" onkeyup="validate('7')" onkeydown="validate('7')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="January" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc8" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p8" onkeyup="validate('8')" onkeydown="validate('8')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="February" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc9" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p9" onkeyup="validate('9')" onkeydown="validate('9')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="March" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc10" style="text-align:center;width:100px"></td>
             <td><input type="text" class="p" name="p[]" id="p10" onkeyup="validate('10')" onkeydown="validate('10')" style="text-align:center;width:100px"></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="April" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc11" style="text-align:center;width:100px" ></td>
             <td><input type="text" class="p" name="p[]" id="p11" onkeyup="validate('11')" onkeydown="validate('11')" style="text-align:center;width:100px"  ></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="May" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc12" style="text-align:center;width:100px"  ></td>
             <td><input type="text" class="p" name="p[]" id="p12" onkeyup="validate('12')" onkeydown="validate('12')" style="text-align:center;width:100px" ></td>
           </tr>
           <tr>
             <td><input type="text" name="Total" value="Total" readonly></td>
             <td><input id="tdc" type="text" name="Tdc" style="text-align:center;width:100px"></td>
             <td><input type="text" id="tp" name="Tp" style="text-align:center;width:100px" ></td>
           </tr>

         </tbody>

       </table>
          
     <button class="btn btn-success" type="submit">Save</button>
     </div>

    </form>
    </div>
    <script>
      $(document).ready(function() {
    // Existing calculations
    calculateSum();
    calculateAVE();
    acts();

    // Recalculate on changes
    $(".dc").on("keydown keyup", calculateSum);
    $(".p").on("keydown keyup", calculateAVE);
    $("#table-body").on("keydown keyup", "input", function() {
        var rowId = $(this).closest('tr').attr('class');
        calculateSum2(rowId);
    });

    // Save button click event
    $("form").on("submit", function(e) {
        e.preventDefault(); // Prevent default form submission
        var confirmed = confirm("Do you want to save this record?");
        if (confirmed) {
            this.submit(); // Submit the form if confirmed
        }
    });
});

    $(document).ready(function() {
    // Calculate on page load to ensure initial values are set
    calculateSum();
    calculateAVE();
    acts();

    // Recalculate on changes
    $(".dc").on("keydown keyup", calculateSum);
    $(".p").on("keydown keyup", calculateAVE);
    $("#table-body").on("keydown keyup", "input", function() {
        var rowId = $(this).closest('tr').attr('class');
        calculateSum2(rowId);
    });
});

function calculateSum() {
    var sum = 0;
    $(".dc").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
            $(this).css("background-color", "white");
        } else if (this.value.length != 0) {
            $(this).css("background-color", "red");
        }
    });
    $("input#tdc").val(sum.toFixed(0));
}

function calculateSum2(i) {
    var sum = 0;
    $(".grade" + i).each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
            $(this).css("background-color", "white");
        } else if (this.value.length != 0) {
            $(this).css("background-color", "rgba(255, 0, 0, 0.49)");
        }
        if (this.value > 100) {
            $(this).css("background-color", "rgba(255, 0, 0, 0.49)");
        }
    });
    if (sum < 75) {
        $("input#action" + i).val("FAILED");
    } else {
        $("input#action" + i).val("PASSED");
    }
    $("input#fin" + i).val((sum / 4).toFixed(2));
}

function calculateAVE() {
    var sum = 0;
    $("input.p").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
            $(this).css("background-color", "white");
        } else if (this.value.length != 0) {
            $(this).css("background-color", "red");
        }
    });
    $("input#tp").val(sum.toFixed(0));
}

function acts() {
    $("input#action").each(function() {
        if ($(this).val() === 'FAILED') {
            $("input#stats").val('Retained');
        } else {
            $("input#stats").val('Promoted');
        }
    });
}

function validate(i) {
    if ($("#p" + i).val() > $("#dc" + i).val()) {
        $("#p" + i).css("background-color", "rgba(255, 0, 0, 0.49)");
    } else {
        $("#p" + i).css("background-color", "white");
    }
}
