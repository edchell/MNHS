<?php
include 'db.php';
$user = $_SESSION['ID'];


	$id = $_GET['id'];

	$query = mysqli_query($conn,"SELECT * FROM student_info where STUDENT_ID = '$id' ");
	$row = mysqli_fetch_assoc($query);
	$student = $row['FIRSTNAME'].' '. $row['LASTNAME'];

	mysqli_query($conn, "INSERT into history_log (transaction,user_id,date_added) 
		VALUES ('printed $student permanent record','$user',NOW() )");

$request = $_SERVER['REQUEST_URI'];

if (strpos($request, '.php') !== false) {
    // Redirect to remove .php extension
    $new_url = str_replace('.php', '', $request);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/logo.jpg">
    <title>MNHS - Student Grading System</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
    <link href="asset/css/plugins/morris.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
    <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">
    <script src="assets/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/jq.js"></script>
</head>
<style>
    * {
        margin: 0 auto;
        padding: 0;
    }
    body {
        background-color: white;
        color: black;
        font-size: 15px;
    }
    .printContainer {
        text-align: center;
        margin-top: 1%;
        width: 100%;
        height: 100%;
    }
    .btn-head {
        margin-left: 2%;
        margin-top: -2%
    }
    .left-head {
        text-align: left;
    }
    .left-head p {
        margin-bottom: 2px;
        margin-left: 10%;
    }
    .center-head {
        margin-top: -20px;
        display:flex;
        align-items:center;
        justify-content:space-between;
    }
    .kd {
        width:220px;
        height:200px;
    }
    .deped {
        width:230px;
        height:230px;
    }
    .stu-info {
        display:flex;
        align-items:center;
        justify-content:space-between;
    }
    .dob {
        display:flex;
        align-items:center;
        justify-content:space-between;
    }


    @media print {
        .btn-head {
            visibility: hidden;
        }
        .left-head {
            text-align: left;
        }
        .left-head p {
            margin-bottom: -3px;
            margin-left: 0;
        }
        .printContainer {
            position: absolute;
            top: -1%;
            left: 0;
            right: 0;
            width: 100%;
        }
        .kd {
            width:100px;
            height:90px;
        }
        .deped {
            width:140px;
            height:170px;
        }
        .pob {
            display:flex;
            align-items:center;
            justify-content:space-between;
        }
    }
</style>

<script type="text/javascript">
        function autoPrint() {
            window.print();
        }
    </script>
<body onload="autoPrint();">
	<div class="printContainer">
		<div class="left-head">
			<p>DepEd Form 137-A</p>
			<p>LRN No.</p>
		</div>
        <div class="center-head">
			<div>
				<img src="images/logo.png" alt="" class="kd">
			</div>
			<div>
				<p style="margin-bottom:-3px;">Department of Education</p>
				<p style="margin-bottom:-3px;">Region VII</p>
				<p style="margin-bottom:-3px;">Province of Cebu</p>
				<p style="margin-bottom:-3px;"><b>Madridejos National High School</b></p>
				<p style="margin-bottom:-3px;">Poblacion, Madridejos, Cebu</p>
			</div>
			<div>
				<img src="images/deped.png" alt="" class="deped">
			</div>
		</div>
        <p style="margin-bottom:-10px;margin-top:-25px;"><b><h4>SECONDARY STUDENT' PERMANENT RECORD</h4></b></p>
        <div class="stu-info">
            <div>
		    	<label for="name"><h6 style="font-size:12px;">Name:</h6></label>
				<span id="name">
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;"><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME']; ?></p></label>
				</span>
			</div>
            <div class="dob">
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
        </div>
        <div class="dob" style="margin-top:-5px;width:100%;">
			<div>
				<label><h6 style="font-size:12px;">Place of Birth:</h6></label>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">Province</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:140px;"><?php $parts = explode(',', $row['BIRTH_PLACE']); echo isset($parts[2]) ? trim($parts[2]) : '';?></p></label>
				</span>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">Municipality</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:150px;"><?php $parts = explode(',', $row['BIRTH_PLACE']); echo isset($parts[1]) ? trim($parts[1]) : '';?></p></label>
				</span>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">Barangay</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:150px;"><?php $parts = explode(',', $row['BIRTH_PLACE']); echo isset($parts[0]) ? trim($parts[0]) : '';?></p></label>
				</span>
			</div>
		</div>
        <div class="dob" style="margin-top:-7px;">
			<div class="pob">
				<label><h6 style="font-size:12px;">Parents/Guardian</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:200px;"><?php echo $row['PARENT_GUARDIAN']?></p></label>
				</span>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">Address of Parents/Guardian</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;"><?php echo $row['P_ADDRESS']?></p></label>
				</span>
			</div>
		</div>
		<div class="dob" style="margin-top:-5px;">
			<div class="pob">
				<label><h6 style="font-size:12px;">Junior/Senior High School Attended</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:300px;">Madridejos National High School</p></label>
				</span>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">School Year</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:120px;"><?php echo $row['SCHOOL_YEAR'] ?></p></label>
				</span>
			</div>
		</div>
		<div style="display:flex;align-items:center;justify-content:space-between;margin-top:-6px">
			<div>
				<label><h6 style="font-size:12px;">Total Number of Years in School to Complete Junior/Senior High School</h6></label>
				<span>
					<label for=""><input type="text" style="font-weight:bold;border:none;border-bottom:1px solid black;width:279px;padding-left:20px;"></label>
				</span>
			</div>
		</div>
        <hr style="border-color:black;border:1px solid black;margin-top:-3px;"></hr>
        <?php
		$sql1 = mysqli_query($conn,"SELECT * FROM student_year_info left join grade on student_year_info.YEAR=grade.grade_id where STUDENT_ID = '$id'");
		$num1 = mysqli_num_rows($sql1);
		while($row1 = mysqli_fetch_assoc($sql1)){
		?>
        <div class="dob" style="margin-top:-18px">
			<div class="pob">
				<label><h6 style="font-size:12px;">Curriculum Year</h6></label>
				<span>
					<label for=""><input type="text" style="font-weight:bold;border:none;border-bottom:1px solid black;width:200px;padding-left:10px;"></label>
				</span>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">School</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:350px;padding-left:10px;">Madridejos National High School</p></label>
				</span>
			</div>
		</div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:-16px;">
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
					<label for=""><input type="text" style="font-weight:bold;border:none;border-bottom:1px solid black;width:100px;padding-left:10px;"></label>
				</span>
			</div>
		</div>
        <table style="width: 90%">
            <tr>
                <td style="width:150px;border:1px solid black;font-size:10px;height:15px;text-align:center;"><b>Subjects</b></td>
                <td style="width:60px;border:1px solid black;font-size:10px;height:15px;text-align:center"><b>Final Rating</b></td>
                <td style="width:83px;border:1px solid black;font-size:10px;height:15px"><b>Action<br>Taken</b></td>
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
		        <td style="width:83px;border:1px solid black;font-size:10px;height:15px"><center><?php echo $row2['PASSED_FAILED'] ?></center></td>
		    </tr>
		    <?php
	            }
			
	        }	
			for($q = $num4; $q < 7 ; $q++){
		    ?>
		    <tr>
                <td style="width:150px;border:1px solid black;font-size:12px;height:15px"></td>
                <td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
                <td style="width:83px;border:1px solid black;font-size:12px;height:15px"></td>
		    </tr>
		    <?php
		        }
		    ?>
        </table>
        </table>
		<center><p style="font-weight:bolder;margin-top:2%;">Attendance Report</p></center>
		<table style="border-collapse:collapse;width: 90%;margin-bottom:20px;margin-top:2%;">
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
				<hr style="border-color:black;border:1px solid black;margin-top:-4px;margin-bottom:3%"></hr>
			</tr>
		</table>
        <?php
            }
        ?>
	</div>
</body>
</html>