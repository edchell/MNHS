<?php
include('auth.php');
?>
<!--$("#rowws").clone().appendTo("#table-body").show();-->
<script>
    $(document).ready(function(){
        $("#rowwss").hide();

        if($('#yr').val() == '1'){
            $('#class').val('Grade 8');
        } else if($('#yr').val() == '2'){
            $('#class').val('Grade 9');
        } else if($('#yr').val() == '3'){
            $('#class').val('Grade 10');
        } else if($('#yr').val() == '4'){
            $('#class').val('Grade 11');
        }
    });

    function newrow($i){
        var data, i = $i + 1;
        data = '<tr id="rowws" class="'+i+'">'+
           '<td style="width:50px;text-align:center;height:30px;font-size:12px">'+
             '<select name="subj[]" onchange="handleSubjectChange('+i+')">'+
             '<option></option>'+
             '<?php include "db.php";
              $sql = mysqli_query($conn, "SELECT * from subjects");
              while($row = mysqli_fetch_assoc($sql)){
                  $id = $row["SUBJECT_ID"];
                  $subj = $row["SUBJECT"];
             ?>'+
                '<option value="<?php echo $id ?>"><?php echo $subj ?> </option>'+
                '<?php } mysqli_close($conn); ?>'+
            '</select> </td>'+
            '<td style="width:50px;text-align:center;height:30px;font-size:12px">'+
             '<input style="width:50px" class="grade'+i+'" onkeyup="calculateSum2('+i+')" onkeydown="calculateSum2('+i+')" type="text" name="1st[]"></td><td style="width:50px;text-align:center;height:30px;font-size:12px">'+
            ' <input style="width:50px" class="grade'+i+'" onkeyup="calculateSum2('+i+')" onkeydown="calculateSum2('+i+')" type="text" name="2nd[]"></td><td style="width:50px;text-align:center;height:30px;font-size:12px">'+
             '<input style="width:50px" class="grade'+i+'" onkeyup="calculateSum2('+i+'>)" onkeydown="calculateSum2('+i+')" type="text" name="3rd[]"></td>'+
             '<td style="width:50px;text-align:center;height:30px;font-size:12px">'+
             '<input style="width:50px" class="grade'+i+'" onkeyup="calculateSum2('+i+')" onkeydown="calculateSum2('+i+')" type="text" name="4th[]"></td>'+
             '<td style="width:60px;text-align:center;height:30px;font-size:12px">'+
            '<input style="width:50px;text-align:center" id="fin'+i+'" type="number" name="final[]" readonly=""></td>'+
             '<td style="width:60px;text-align:center;height:30px;font-size:12px">'+
              '<input type="text" name="action[]" id="action'+i+'" style="text-align:center" readonly="" >'+

              '</td>'+
             ' <td><a onclick="remtrr('+i+')"  id="remtr">X</a></td>'+
            '</tr>';
        $("#table-body").append(data);
        disableSubject();
    }

    function remtrr($i){
        $("." + $i).remove();
        handleSubjectChange(currentIndex); // Recheck selections when row is removed
    }
</script>
  
    <?php
    include 'db.php';


    $sql=  mysqli_query($conn, "SELECT * FROM student_info where STUDENT_ID = '".$_GET['id']."' ");
    while($row = mysqli_fetch_assoc($sql)) {


    ?>
    <div class="d-flex align-items-center justify-content-between">
          <a href="rms.php?page=record&id=<?php echo $row['STUDENT_ID'] ?>" class="btn btn-primary">BACK</a>
          <h1 class="page-header"><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></h1>
          </div>
          <?php
    } mysqli_close($conn);
      ?>
     <form id="myForm" action="newrecord.php" method="post">
     <input name="id" type="hidden" value="<?php echo $_GET["id"] ?>">
     <div class="col-md-6">
       <div class="row">
       <label class="col-md-4 te" for="school">School</label>
       <div class="col-md-6">
       <?php
    include 'db.php';
    $sql=  mysqli_query($conn, "SELECT * FROM student_info where STUDENT_ID = '".$_GET['id']."' ");
    while($row = mysqli_fetch_assoc($sql)) {
    ?>
         <input type="text" name="school" class="form-control" id ="school" value="<?php echo $row['INT_COURSE_COMP'] ?>" readonly>
         <?php
    } mysqli_close($conn);
      ?>
        </div>
       </div>
       <br>
       <div class="row">
       <label class="col-md-4 te" for="yr">Grade</label>
       <div class="col-md-6">
         <select type="text" name="yr" class="form-control" id ="yr" required>
        <?php 
       include 'db.php';
       $id = $_GET['id'];
       $query=mysqli_query($conn,"SELECT * from student_year_info where STUDENT_ID = '$id' order by SYI_ID DESC limit 1");
       $count = mysqli_num_rows($query);
       if($count > 0){
       while($row = mysqli_fetch_assoc($query)){
        $g=$row['TO_BE_CLASSIFIED'] ;
        $query1=mysqli_query($conn,"SELECT * from grade where grade = '$g'");
       while($row1 = mysqli_fetch_assoc($query1)){

       ?>
         <option value="<?php echo $row1['grade_id'] ?>"><?php echo $row1['grade']  ?></option>
         <?php } 
          ?>
          <?php 
             $query2=mysqli_query($conn,"SELECT * from grade where grade != '$g'");
       while($row2 = mysqli_fetch_assoc($query2)){
          ?>
            <option value="<?php echo $row2['grade_id'] ?>"><?php echo $row2['grade']  ?></option>
          <?php } }
          }else{ ?>

         <?php 
             $query2=mysqli_query($conn,"SELECT * from grade order by ABS(grade) asc limit 1");
       while($row2 = mysqli_fetch_assoc($query2)){
          ?>
            <option value="<?php echo $row2['grade_id'] ?>"><?php echo $row2['grade']  ?></option>
            <?php } } ?>
          </select>
       </div>
       </div>
       <br>
       <div class="row">
       <label class="col-md-4 te" for="sec">Section</label>
       <div class="col-md-6">
         <input type="text" name="sec" class="form-control" id ="sec"required>
       </div>
       </div>
     </div>
     <div class="col-md-6">
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
         <input type="text" name="tny" class="form-control" id ="" value="<?php echo $srow['TOTAL_NO_OF_YEARS'] ?>" readonly>
          <?php }else{ ?>
          <input type="text" name="tny" class="form-control" id ="" value="<?php echo $trow['TOTAL_NO_OF_YEAR'] ?>" readonly>
            <?php
            } ?>
       </div>
       </div>
       <br>
     <div class="row">
       <label class="col-md-4 te" for="sy">School Year</label>
       <div class="col-md-6">
         <input type="text" name="sy" class="form-control" id ="sy" value="<?php echo $_GET['sy'] ?>" readonly >
       </div>
       </div>
       <br>
       <div id="en_adv">
       <div class="row">
       <label class="col-md-4 te" for="adviser">Adviser</label>
       <div class="col-md-6">
         <input type="text" name="adviser" class="form-control" id ="adviser" >
       </div>
       </div>
       </div>
        <br>
     </div>

     <div class="col-md-7">
     <br>
     <br>
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
             <th style="width:50px;text-align:center"></th>
           </tr>
         </thead>
         <tbody id="table-body">
         <?php
          for($i =0 ; $i<1; $i++){
          ?>
         <tr id="rowws" class="<?php echo $i ?>">
           <td style="width:50px;text-align:center;height:30px;font-size:12px">
           <select name="subj[]" id="subj<?php echo $i ?>" onchange="handleSubjectChange(<?php echo $i ?>)" required>
             <option></option>
             <?php
              include 'db.php';
              $sql = mysqli_query($conn, " SELECT * from subjects");
              while($row=mysqli_fetch_assoc($sql)){
                $id = $row['SUBJECT_ID'];
                $subj = $row['SUBJECT'];
?>
                <option value="<?php echo $id ?>" data-subject="<?php echo $subj ?>"><?php echo $subj ?> </option>
                <?php
              }
              mysqli_close($conn);
              ?>

            </select> </td>
             <td style="width:50px;text-align:center;height:30px;font-size:12px">
             <input style="width:50px" class="grade<?php echo $i ?>" onkeyup="calculateSum2(<?php echo $i ?>)" onkeydown="calculateSum2(<?php echo $i ?>)" type="text" name="1st[]" oninput="validateNumber(event)" maxlength="3" required></td><td style="width:50px;text-align:center;height:30px;font-size:12px">
             <input style="width:50px" class="grade<?php echo $i ?>" onkeyup="calculateSum2(<?php echo $i ?>)" onkeydown="calculateSum2(<?php echo $i ?>)" type="text" name="2nd[]" oninput="validateNumber(event)" maxlength="3" required></td><td style="width:50px;text-align:center;height:30px;font-size:12px">
             <input style="width:50px" class="grade<?php echo $i ?>" onkeyup="calculateSum2(<?php echo $i ?>)" onkeydown="calculateSum2(<?php echo $i ?>)" type="text" name="3rd[]" oninput="validateNumber(event)" maxlength="3" required></td>
             <td style="width:50px;text-align:center;height:30px;font-size:12px">
             <input style="width:50px" class="grade<?php echo $i ?>" onkeyup="calculateSum2(<?php echo $i ?>)" onkeydown="calculateSum2(<?php echo $i ?>)" type="text" name="4th[]" oninput="validateNumber(event)" maxlength="3" required></td>
             <td style="width:60px;text-align:center;height:30px;font-size:12px">
             <input style="width:50px;text-align:center" id="fin<?php echo $i ?>" type="number" name="final[]" readonly=""></td>
             <td style="width:60px;text-align:center;height:30px;font-size:12px">
              <input type="text" name="action[]" id="action<?php echo $i ?>" style="text-align:center" readonly="" >

              </td>
              <td><a onclick="remtrr(<?php echo $i ?>)"  id="remtr">X</a></td>
              </tr>
              <?php
              } ?>
           
         </tbody>

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
             <td><input class="dc" type="text" name="dc[]" id="dc1" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p1" onkeyup="validate('1')" onkeydown="validate('1')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="July" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc2" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p2" onkeyup="validate('2')" onkeydown="validate('2')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="August" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc3" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p3" onkeyup="validate('3')" onkeydown="validate('3')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="September" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc4" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p4" onkeyup="validate('4')" onkeydown="validate('4')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="October" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc5" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p5" onkeyup="validate('5')" onkeydown="validate('5')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="November" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc6" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p6" onkeyup="validate('6')" onkeydown="validate('6')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="December" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc7" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p7" onkeyup="validate('7')" onkeydown="validate('7')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="January" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc8" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p8" onkeyup="validate('8')" onkeydown="validate('8')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="February" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc9" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p9" onkeyup="validate('9')" onkeydown="validate('9')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="March" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc10" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p10" onkeyup="validate('10')" onkeydown="validate('10')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="April" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc11" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p11" onkeyup="validate('11')" onkeydown="validate('11')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="month[]" value="May" readonly></td>
             <td><input class="dc" type="text" name="dc[]" id="dc12" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
             <td><input type="text" class="p" name="p[]" id="p12" onkeyup="validate('12')" onkeydown="validate('12')" style="text-align:center;width:100px" oninput="validateNumber(event)" maxlength="2" required></td>
           </tr>
           <tr>
             <td><input type="text" name="Total" value="Total" readonly></td>
             <td><input id="tdc" type="text" name="Tdc" style="text-align:center;width:100px" readonly></td>
             <td><input type="text" id="tp" name="Tp" style="text-align:center;width:100px" readonly></td>
           </tr>

         </tbody>

       </table>
          <br>
     <button class="btn btn-success" type="submit">Save</button>
     </div>

    </form>
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

  
function validateNumber(event) {
    const input = event.target;
    input.value = input.value.replace(/[^0-9]/g, ''); // Remove anything that's not a number
}

  // Function to disable subjects already selected in other dropdowns
  function disableSubject() {
        let selects = document.querySelectorAll('select[name="subj[]"]');
        let selectedValues = [];

        // Collect selected values from all select elements
        selects.forEach(select => {
            let selectedOption = select.options[select.selectedIndex];
            if (selectedOption.value) {
                selectedValues.push(selectedOption.value);
            }
        });

        // Enable all options first
        selects.forEach(select => {
            for (let option of select.options) {
                option.style.display = 'block';
            }
        });

        // Disable the selected options in other dropdowns
        selects.forEach(select => {
            for (let option of select.options) {
                if (selectedValues.includes(option.value) && option.value !== "") {
                    option.style.display = 'none';
                }
            }
        });
      }

    // Handle both disabling and new row creation on subject change
    function handleSubjectChange(currentIndex) {
        disableSubject();
        newrow(currentIndex); // add the next row if necessary
    }
    </script>
 
 <script>
$(document).ready(function() {
    $("#myForm").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        var formData = $(this).serialize(); // Serialize form data for AJAX
        
        $.ajax({
            url: 'newrecord.php',
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect JSON response from PHP
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'rms.php?page=record&id=<?php echo $_GET['id']; ?>';
                        }
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue processing your request. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
 