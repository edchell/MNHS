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
        margin-top: 2%;
        width: 100%;
    }
    .btn-head {
        margin-left: 2%
    }
    .left-head {
        text-align: left;
    }
    .left-head p {
        margin-bottom: 2px;
        margin-left: 10%;
    }
    .center-head {
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
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
        }
        .kd {
            width:140px;
            height:120px;
        }
        .deped {
            width:170px;
            height:190px;
        }
        .pob {
            display:flex;
            align-items:center;
            justify-content:space-between;
        }
    }
</style>
<body>
    <div class="btn-head">
        <button class="btn btn-info" onclick="window.print()">Print</button>
        <button class="btn btn-info" onclick="window.close()">Cancel</button>
    </div>
	<div class="printContainer">
		<div class="left-head">
			<p>DepEd Form 137-A</p>
			<p>LRN No.</p>
		</div>
        <br>
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
        <p style="margin-bottom:-10px;margin-top:-17px;"><b><h4>SECONDARY STUDENT' PERMANENT RECORD</h4></b></p>
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
        <div class="dob">
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
        <div class="dob">
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
		<div class="dob">
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
		<div style="display:flex;align-items:center;justify-content:space-between;">
			<div>
				<label><h6 style="font-size:12px;">Total Number of Years in School to Complete Junior/Senior High School</h6></label>
				<span>
					<label for=""><input type="text" style="font-weight:bold;border:none;border-bottom:1px solid black;width:279px;padding-left:20px;"></label>
				</span>
			</div>
		</div>
        <hr style="border-color:black;border:1px solid black;margin-top:-3px;"></hr>
        <div class="dob">
			<div class="pob">
				<label><h6 style="font-size:12px;">Curriculum Year</h6></label>
				<span>
					<label for=""><input type="text" style="font-weight:bold;border-bottom:1px solid black;width:200px;padding-left:10px;"></label>
				</span>
			</div>
			<div class="pob">
				<label><h6 style="font-size:12px;">School</h6></label>
				<span>
					<label for=""><p style="font-weight:bold;border-bottom:1px solid black;width:350px;padding-left:10px;">Madridejos National High School</p></label>
				</span>
			</div>
		</div>
	</div>
</body>
</html>