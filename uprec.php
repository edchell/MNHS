<?php
session_start();
include 'db.php';

$syi_id = $_POST['syi'];
$id = $_POST['id'];
$adv= $_POST['adviser'];
$tg_id = $_POST['tg_id'];
$subject = $_POST['subj'];
$una = $_POST['1st'];
$ikaduwa = $_POST['2nd'];
$ikatlo = $_POST['3rd'];
$ikaapat = $_POST['4th'];
$f = $_POST['final'];
$action = $_POST['action'];
$att_id = $_POST['att_id'];
$dc = $_POST['dc'];
$Tdc = $_POST['Tdc'];
$att_d = $_POST['att_d'];
$pp = $_POST['pp'];
$Tp = $_POST['Tp'];
$user= $_SESSION["ID"];

if(isset($_POST['sub']	)){
$sub = $_POST['sub'];
$one = $_POST['una'];
$two = $_POST['duwa'];
$three = $_POST['tatlo'];
$four = $_POST['apat'];
$fin = $_POST['fin'];
$act = $_POST['action'];

$subc= count($sub);
		

			for($q=0;$q < $subc;$q++){
				if($act[$q] == ""){

				}else{
				mysqli_query($conn,"INSERT INTO total_grades_subjects (STUDENT_ID, SYI_ID, SUBJECT, 1ST_GRADING, 2ND_GRADING, 3RD_GRADING, 4TH_GRADING, FINAL_GRADES, PASSED_FAILED)
				VALUES('$id', '$syi_id', '$sub[$q]', '$one[$q]', '$two[$q]', '$three[$q]', '$four[$q]', '$fin[$q]', '$act[$q]')");
			} 
		}
			}

			$query = mysqli_query($conn, "SELECT * FROM student_info Where STUDENT_ID = '$id' ");
			while ($row = mysqli_fetch_assoc($query)) {
				$student = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];

				mysqli_query($conn, "INSERT into history_log (transaction,user_id,date_added)
				VALUES ('Updated $student academic record', '$user', NOW())");
			}

			$sc= count($tg_id);

			for($w=0;$w < $sc;$w++){
				
				mysqli_query($conn,"UPDATE total_grades_subjects set  SUBJECT='$subject[$w]', 1ST_GRADING ='$una[$w]', 2ND_GRADING='$ikaduwa[$w]', 3RD_GRADING ='$ikatlo[$w]', 4TH_GRADING='$ikaapat[$w]', FINAL_GRADES='$f[$w]', PASSED_FAILED ='$action[$w]' where TGS_ID = '$tg_id[$w]' ");
			}

		$mc = count($att_id);

		for($i=0 ; $i < $mc; $i++)
		{
			
			mysqli_query($conn,"UPDATE  attendance set DAYS_OF_CLASSES ='$dc[$i]' where ATT_ID= '$att_id[$i]' ") ;
				
		}

		$mc2 = count($att_d);

		for($z=0 ; $z < $mc2; $z++)
		{
			
			mysqli_query($conn,"UPDATE  attendance set DAYS_PRESENT ='$pp[$z]' where ATT_ID= '$att_d[$z]' ") ;
				
		}

		$gen= mysqli_query($conn,"SELECT *, SUM(FINAL_GRADES) as fin_gra,count(TGS_ID) as gra_count from total_grades_subjects where SYI_ID='$syi_id' ");
		$fgen=mysqli_fetch_assoc($gen);
		$ga = $fgen['fin_gra'] / $fgen['gra_count'];


		$sql= mysqli_query($conn,"UPDATE student_year_info set ADVISER='$adv',TDAYS_OF_CLASSES='$Tdc',TDAYS_PRESENT='$Tp' where SYI_ID='$syi_id' ");
		
	  	echo json_encode(['status' => 'success', 'message' => 'Student record updated successfully!']);
		exit;
			 
		mysqli_close($conn);
?>