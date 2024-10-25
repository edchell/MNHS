<?php
include('auth.php');

include 'db.php';
$user = $_SESSION['ID'];


	$id = $_GET['id'];

	$query = mysqli_query($conn,"SELECT * FROM student_info where STUDENT_ID = '$id' ");
	$row = mysqli_fetch_assoc($query);
	$student = $row['FIRSTNAME'].' '. $row['LASTNAME'];

	mysqli_query($conn, "INSERT into history_log (transaction,user_id,date_added) 
		VALUES ('printed $student permanent record','$user',NOW() )");

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="images/logo.jpg">

    <title>MNHS - Student Grading System</title>

     <!-- Bootstrap Core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="asset/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="asset/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
        <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">

    <script src="assets/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/jq.js"></script>
	<style>
	@media print {  
		@page {
			size:9.5in 13in;
		}
		head{
			height:0px;
			display: none;
		}
		#head{
			display: none;
			height:0px;
		}
		#print{
		position:fixed;
		top:0px;
		margin-top:20px;
		margin-bottom:30px;
		margin-right:50px;
		margin-left:50px;
		}
		}
		#print{
		width:7.5in;
		}
		input {
    border: 0;
    outline: 0;
    background: transparent;
    border-bottom: 1px solid black;
}

.foo{
	font-family: "Bodoni MT", Didot, "Didot LT STD", "Hoefler Text", Garamond, "Times New Roman", serif;
	font-size: 24px;
	font-style: italic;
	font-variant: normal;
	font-weight: bold;
	line-height: 24px;
	}
	.p {
	font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
	font-size: 14px;
	font-style: italic;
	font-variant: normal;
	font-weight: 550;
	line-height: 20px;
	 letter-spacing: 2px;
}
	</style>

</head> 
<body style="background-color:white;color:black;"> 
<span id='returncode'></span>
<div class="col-md-2" id="head">
	<button class="btn btn-info" onclick="print()"><i class="glyphicon glyphicon-print"></i>PRINT</button>
	<a class="btn btn-info" onclick="window.close()">Cancel</a>
	
</div>
<br>
<center>
<div id='print'>
	<div style="display:flex;flex-direction:column;float:left;">
	<p style="font-style:italic;font-size:11px;margin-left:-120px;">DepEd Form 137-A</p>
	<p style="font-size:12px;margin-top:-10px;">LRN: No.:
		<span><input disabled value="<?php echo $row['LRN_NO'] ?>"></span>
	</p>
	</div>
	<br>
	<br>
	<br>
<div style="margin-left:.5in;margin-right:.5in;margin-top:.1in;margin-bottom:.1in;line-height:1mm;">
			<div style="display:flex;align-items:center;justify-content:space-between;">
				<div>
					<img src="images/logo.png" alt="" style="width:90px;height:90px;">
				</div>
				<div>
					<center><p style="font-size:12px;margin-bottom:13px;">Department of Education</p></center>
					<center><p style="font-size:12px;margin-bottom:13px;">Region VII</p></center>
					<center><p style="font-size:12px;margin-bottom:13px;">Province of Cebu</p></center>
					<center><p><b>Madridejos National High School</b></p></center>
					<center><p style="font-size:12px;margin-top:13px;">Poblacion, Madridejos, Cebu</p></center>
				</div>
				<div>
					<img src="images/deped.png" alt="" style="width:120px;height:120px;">
				</div>
			</div>
</div>
		  <div class="row" style="margin-top:-7px;">
		  <div class="col-md-12">
		  <center><p><b><h4>SECONDARY STUDENT' PERMANENT RECORD</h4></b></p></center>
		  </div>
          </div>
          <div class="row">
		  <div class="col-md-12">

		  <table style="line-height:5mm">
		<?php 
		include 'db.php';
		$id = $_GET['id'];
		$sql = mysqli_query($conn,"SELECT * from student_info where STUDENT_ID = '$id'");
		while($row = mysqli_fetch_assoc($sql)){
			$mid = $row['MIDDLENAME'];
		?>
			<div style="display:flex;align-items:center;justify-content:between;margin-top:-10px;">
				<div>
					<label for="name"><h6 style="font-size:12px;">Name:</h6></label>
					<span id="name">
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;"><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME']; ?></p></label>
					</span>
				</div>
				<div>
					<label for="dob"><h6 style="font-size:12px;">Date of Birth:</h6></label>
				</div>
				<div>
					<label for=""><h6 style="font-size:12px;">Year</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:60px;"><?php echo date('Y', strtotime($row['DATE_OF_BIRTH'])); ?></p></label>
					</span>
				</div>
				<div>
					<label for=""><h6 style="font-size:12px;">Month</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:90px;"><?php echo date('F', strtotime($row['DATE_OF_BIRTH'])); ?></p></label>
					</span>
				</div>
				<div>
					<label for=""><h6 style="font-size:12px;">Day</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:35px;"><?php echo date('d', strtotime($row['DATE_OF_BIRTH'])); ?></p></label>
					</span>
				</div>
		</div>
			<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
				<div>
					<label><h6 style="font-size:12px;">Place of Birth:</h6></label>
				</div>
				<div>
					<label><h6 style="font-size:12px;">Province</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:140px;"><?php $parts = explode(',', $row['BIRTH_PLACE']); echo isset($parts[2]) ? trim($parts[2]) : '';?></p></label>
					</span>
				</div>
				<div>
					<label><h6 style="font-size:12px;">Municipality</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:150px;"><?php $parts = explode(',', $row['BIRTH_PLACE']); echo isset($parts[1]) ? trim($parts[1]) : '';?></p></label>
					</span>
				</div>
				<div>
					<label><h6 style="font-size:12px;">Barangay</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:150px;"><?php $parts = explode(',', $row['BIRTH_PLACE']); echo isset($parts[0]) ? trim($parts[0]) : '';?></p></label>
					</span>
				</div>
			</div>
			<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
				<div>
					<label><h6 style="font-size:12px;">Parents/Guardian</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;"><?php echo $row['PARENT_GUARDIAN']?></p></label>
					</span>
				</div>
			</div>
			<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
				<div>
					<label><h6 style="font-size:12px;">Address of Parents/Guardian</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;"><?php echo $row['P_ADDRESS']?></p></label>
					</span>
				</div>
			</div>
			<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
				<div>
					<label><h6 style="font-size:12px;">Junior/Senior High School Attended</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;">Madridejos National High School</p></label>
					</span>
				</div>
				<div>
					<label><h6 style="font-size:12px;">School Year</h6></label>
					<span>
						<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:120px;"><?php echo $row['SCHOOL_YEAR'] ?></p></label>
					</span>
				</div>
			</div>
			<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
				<div>
					<label><h6 style="font-size:12px;">Total Number of Years in School to Complete Junior/Senior High School</h6></label>
					<span>
						<label for=""><input type="text" style="font-weight:bold;border-bottom:1px solid black;width:279px;padding-left:20px;"></label>
					</span>
				</div>
			</div>
			
			</table> 
		<?php } ?>
		  </div>
          </div>
          <div class="row">
          <div class="col-md-12">
          <hr style="border-color:black;border:1px solid black;margin-top:-4px;"></hr>
          </div>
          
          </div>

          <p style="">
          <?php
		$sql1 = mysqli_query($conn,"SELECT * FROM student_year_info left join grade on student_year_info.YEAR=grade.grade_id where STUDENT_ID = '$id'");
		$num1 = mysqli_num_rows($sql1);

		

		while($row1 = mysqli_fetch_assoc($sql1)){
		?>
		<table style="float:left;margin-left:5px;margin-bottom:20px;">
		<tr>
		<td>  
		<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
			<div>
				<label><h6 style="font-size:12px;">Curriculum Year</h6></label>
				<span>
					<label for=""><input type="text" style="font-weight:bold;border-bottom:1px solid black;width:200px;padding-left:10px;"></label>
				</span>
			</div>
			<div>
				<label><h6 style="font-size:12px;">School</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:350px;padding-left:10px;">Madridejos National High School</p></label>
				</span>
			</div>
		</div>
		<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
			<div>
				<label><h6 style="font-size:12px;">Yr. & Sec</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:200px;padding-left:10px;"><?php echo $row1['grade'] . '-' . $row1['SECTION']  ?></p></label>
				</span>
			</div>
			<div>
				<label><h6 style="font-size:12px;">School Year</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:200px;padding-left:10px;"><?php echo $row1['SCHOOL_YEAR']?></p></label>
				</span>
			</div>
			<div>
				<label><h6 style="font-size:12px;">Semester</h6></label>
				<span>
					<label for=""><input type="text" style="font-weight:bold;border-bottom:1px solid black;width:100px;padding-left:10px;"></label>
				</span>
			</div>
		</div>		
		
		<table style="border-collapse:collapse;width:715px;">
		<tr>
		<td style="width:150px;border:1px solid black;font-size:12px;"><center><b>Subjects</b></center></td>
		<td style="width:60px;border:1px solid black;font-size:12px;"><center><b>Final Rating</b></center></td>
		<td style="width:60px;border:1px solid black;font-size:12px;"><center><b>Units Earned</b></center></td>
		<td style="width:10px;border:1px solid black;font-size:12px;"><center><b>Action<br>Taken</b></center></td>
		</tr>
		<?php
		$syi = $row1['SYI_ID'];
		$sql2 = mysqli_query($conn,"SELECT * FROM total_grades_subjects where SYI_ID = '$syi' order by SUBJECT");
		$num4 = mysqli_num_rows($sql2);
		while($row2 = mysqli_fetch_assoc($sql2)){
			$sub = $row2['SUBJECT'];
		$sql3 = mysqli_query($conn,"SELECT * FROM subjects where SUBJECT_ID = '$sub'");
		while($row3 = mysqli_fetch_assoc($sql3)){

		?>
		<tr>
		<td style="width:150px;border:1px solid black;font-size:10px;height:15px;text-align:center;">
			<?php
           if($row3['SUBJECT'] == "     *Music"){
            echo "&nbsp&nbsp&nbsp&nbsp&nbsp".$row3['SUBJECT'];}
            elseif($row3['SUBJECT'] == "     *Arts"){
              echo "&nbsp&nbsp&nbsp&nbsp&nbsp".$row3['SUBJECT'];
            }
            elseif($row3['SUBJECT'] == "     *Physical Education"){
              echo "&nbsp&nbsp&nbsp&nbsp&nbsp".$row3['SUBJECT'];
            }
            elseif($row3['SUBJECT'] == "     *Health"){
              echo "&nbsp&nbsp&nbsp&nbsp&nbsp".$row3['SUBJECT'];
            }	
            else{
              echo $row3['SUBJECT'];

            }
            ?>
		</td>
		<td style="width:60px;border:1px solid black;font-size:10px;height:15px;text-align:center"><?php echo $row2['FINAL_GRADES'] ?></td>
		<td style="width:60px;border:1px solid black;font-size:10px;height:15px;text-align:center"><?php echo $row2['UNITS'] ?></td>
		<td style="width:83px;border:1px solid black;font-size:10px;height:15px"><center><?php echo $row2['PASSED_FAILED'] ?></center></td>
		</tr>
		
		<?php
	}
			
	}	
			for($q = $num4; $q < 10 ; $q++){
		 ?>
		
		<tr>
		<td style="width:150px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:83px;border:1px solid black;font-size:12px;height:15px"></td>
		</tr>
		<?php
		}
		?>
		</table>
		<center><p style="font-weight:bolder;">Attendance Report</p></center>
		<table style="border-collapse:collapse;width:715px;margin-bottom:20px;margin-top:-10px;">
			<tr>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:130px">Months</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Jun</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Jul</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Aug</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Sept</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Oct</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Nov</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Dec</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Jan</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">Feb</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">March</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">April</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:50px">May</td>
				<td style="font-size:10px;border:1px solid black;text-align:center;width:130px">Total</td>
			</tr>
			<tr>
				<td style="font-size:10px;text-align:center;width:130px;border:1px solid black;">Days of School</td>
				<?php
					$atten= mysqli_query($conn, "SELECT * FROM attendance where SYI_ID = '$syi' order by ATT_ID ");
					while($att=mysqli_fetch_assoc($atten)){
				?>
				<td style="font-size:10px;text-align:center;width:50px;border:1px solid black;"> <?php echo $att['DAYS_OF_CLASSES'] ?></td>
				<?php } ?>
				<td style="font-size:10px;text-align:center;width:130px;border:1px solid black;"><?php echo $row1['TDAYS_OF_CLASSES'] ?> </td>
			</tr>
			<tr>
				<td style="font-size:10px;text-align:center;width:130px;border:1px solid black;">Days Present</td>
				<?php
					$atten2= mysqli_query($conn, "SELECT * FROM attendance where SYI_ID = '$syi' order by ATT_ID ");
					while($att2=mysqli_fetch_assoc($atten2)){
				?>
				<td style="font-size:10px;text-align:center;width:50px;border:1px solid black;"><?php echo $att2['DAYS_PRESENT'] ?></td>
				<?php } ?>
				<td style="font-size:10px;text-align:center;width:130px;border:1px solid black;"><?php echo $row1['TDAYS_PRESENT'] ?></td>
			</tr>
		</table>
		<table>
			<tr>
				<hr style="border-color:black;border:1px solid black;margin-top:-4px;"></hr>
			</tr>
		</table>
          <?php
			}
			?>
	<!-- <?php
	for($c =  $num1;$c < 4; $c++){
		?>
		<table style="float:left;margin-left:5px;margin-bottom:20px;">
		<tr>
		<td>
		<table>
			<tr style="width:100%">
			<td>
			<label style="font-size:12px">School:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			</td>
			<td style="border-bottom:1px solid black;width:280px">
		<label style="font-size:12px"></label>
		</td>
		</tr>
		</table>
	
					
					
		<table>
		<tr style="width:100%">
		<td  style="width:200px">
		<label style="font-size:12px">Yr.& Sec:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
		</td>
		<td >
		<label style="font-size:12px">Sch.Yr.:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
		</td>
		</tr>
		</table>
		<table style="border-collapse:collapse">
		<tr>
		<td style="width:150px;border:1px solid black;font-size:12px;"><center><b>Subjects</b></center></td>
		<td style="width:60px;border:1px solid black;font-size:12px;"><center><b>Final Rating</b></center></td>
		<td style="width:60px;border:1px solid black;font-size:12px;"><center><b>Units Earned</b></center></td>
		<td style="width:10px;border:1px solid black;font-size:12px;"><center><b>Action<br>Taken</b></center></td>
		</tr>
		<?php
		
		for($p = 0 ; $p < 7 ; $p++){
		 ?>
		
		<tr>
		<td style="width:150px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:83px;border:1px solid black;font-size:12px;height:15px"></td>
		</tr>
		<?php 
	}
		?>
		<tr>
		<td style="width:150px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;height:15px;font-size:11px;text-align:right"><b>*</b></td>
		<td style="width:60px;height:15px;font-size:11px;text-align:right"><b>**** no &nbsp</b></td>
		<td style="width:83px;border-right:1px solid black;font-size:11px;height:15px;text-align:left"><b>entry *****</b></td>
		</tr>

		<?php
		for($s = 0 ; $s < 7 ; $s++){
		 ?>
		
		<tr>
		<td style="width:150px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:83px;border:1px solid black;font-size:12px;height:15px"></td>
		</tr>
		<?php 
		}
	

		?>
<tr>
		<td style="width:150px;font-size:12px;height:15px">Days of School:</td>
		<td style="width:60px;border-bottom:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60;font-size:12px;height:15px;text-align:right">No. of Ye</td>
		<td style="width:83px;font-size:12px;height:15px">ars in</td>
		</tr>
		<tr>
		<td style="width:150px;font-size:12px;height:15px">Days of Present:</td>
		<td style="width:60px;border-bottom:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60;font-size:12px;height:15px;text-align:right">School:</td>
		<td style="width:83px;border-bottom:1px solid black;font-size:12px;height:15px"></td>
		</tr>

		</table>
		<table style="border-collapse:collapse">
			<tr>
		<td style="width:150px;font-size:12px;height:15px">To be classified as:</td>
		<td style="width:120px;border-bottom:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:83px;font-size:12px;height:15px"></td>
		</tr>
		</table>
		</td>
		</tr>

		</td>
		</tr>

		</table>
		
		<?php 
	

		}
	
	

		?> -->

<?php

 mysqli_close($conn);
?>
</center>
</body>
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;

	$.ajax({
		url:'print_log.php?act=form137&id=<?php echo $_GET['id'] ?>',
		success:function(html){
			$('#returncode').html(html);
		}
	});
}
</script>
</html>