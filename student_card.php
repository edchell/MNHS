<?php
session_start();
include 'db.php';

if (!isset($_GET['stu_id']) || empty($_GET['stu_id'])) {
    header("Location: student_view.php");
    exit;
}

$stu_id = $_GET['stu_id'];

$query = "SELECT STUDENT_ID, FIRSTNAME, LASTNAME FROM student_info WHERE LRN_NO = ?";
$query_stmt = $conn->prepare($query);
$query_stmt->bind_param("s", $stu_id);
$query_stmt->execute();
$query_result = $query_stmt->get_result();
$query_row = $query_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="images/logo.jpg"> -->
    <title>MNHS - Student Grading System</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
    <link href="asset/css/plugins/morris.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="student_card.css">
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>


</head>

<body style="background-color: white;">

<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand title" href="#"><b>MNHS - Student Grading System</b></a>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav dd">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle user-web" data-toggle="dropdown">
                        <i class="fa fa-user"></i> 
                        <span class="user-name">
                        <?php echo htmlspecialchars($query_row['FIRSTNAME'] . ' ' . $query_row['LASTNAME']); ?>
                        </span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-mob">
                            <h5><?php echo htmlspecialchars($query_row['FIRSTNAME'] . ' ' . $query_row['LASTNAME']); ?></h5>
                        </li>
                        <li>
                            <a href="student_logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="content">
    <?php
    $id = $query_row['STUDENT_ID'];
		$sql1 = mysqli_query($conn,"SELECT * FROM student_year_info left join grade on student_year_info.YEAR=grade.grade_id where STUDENT_ID = '$id'");
		$num1 = mysqli_num_rows($sql1);

		

		while($row1 = mysqli_fetch_assoc($sql1)){
		?>
		<table id="table1">
		<tr>
		<td>  
		<div style="display:flex;align-items:center;justify-content:between;margin-top:-20px;">
			<div>
				<label><h6 style="font-size:12px;">Yr. & Sec</h6></label>
				<span>
					<label for=""><p id="year"><?php echo $row1['grade'] . '-' . $row1['SECTION']  ?></p></label>
				</span>
			</div>
			<div>
				<label><h6 style="font-size:12px;">School Year</h6></label>
				<span>
					<label for=""><p id="sy"><?php echo $row1['SCHOOL_YEAR']?></p></label>
				</span>
			</div>
		</div>		
		
		<table id="table2">
		<tr>
		<td id="subject" style="width:150px;border:1px solid black;font-size:12px;"><center><b>Subjects</b></center></td>
		<td id="fr" style="width:60px;border:1px solid black;font-size:12px;"><center><b>Final Rating</b></center></td>
		<td id="at" style="width:10px;border:1px solid black;font-size:12px;"><center><b>Action<br>Taken</b></center></td>
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
		<td id="subject" style="width:150px;border:1px solid black;font-size:10px;height:15px;text-align:center;">
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
			for($q = $num4; $q < 6 ; $q++){
		 ?>
		
		<tr>
		<td id="subject" style="width:150px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:60px;border:1px solid black;font-size:12px;height:15px"></td>
		<td style="width:83px;border:1px solid black;font-size:12px;height:15px"></td>
		</tr>
		<?php
		}
		?>
		</table>
        <hr style="border-color:black;border:1px solid black;margin-top:10px;margin-bottom:40px"></hr>
          <?php
			}
			?>
    </div>
</div>

        <script src="assets/js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>