<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
$id=$_POST['id'];
$lrn=$_POST['lrn'];
$ln=$_POST['lname'];
$fn=$_POST['fname'];
$mn=$_POST['mname'];
$gender=$_POST['gender'];
$bp=$_POST['bp'];
$dob=$_POST['dob'];
$address=$_POST['address'];
$pg=$_POST['pg'];
$pga=$_POST['pga'];
$icc=$_POST['icc'];
$sy=$_POST['sy'];
$tny=$_POST['tny'];
$ave=$_POST['ave'];
$user = $_SESSION['ID'];

include 'db.php';

$search_query = mysqli_query($conn, "SELECT * FROM student_info WHERE LRN_NO = '$lrn' and STUDENT_ID != '$id' ");
		$num_row = mysqli_num_rows($search_query);
		if($num_row >= 1){
			echo "<script>
				Swal.fire({
					icon: 'error',
					title: 'LRN Not Available',
					text: 'The LRN you entered already exists.',
				}).then(() => {
					window.history.back();
				});
			</script>";
		}else{
			$sql = "UPDATE student_info set
			 
			 LRN_NO ='$lrn',
			 LASTNAME ='$ln',
			 FIRSTNAME ='$fn',
			 MIDDLENAME ='$mn',
			 BIRTH_PLACE ='$bp',
			 PARENT_GUARDIAN ='$pg',
			 P_ADDRESS ='$pga',
			 INT_COURSE_COMP ='$icc',
			 SCHOOL_YEAR ='$sy',
			 GEN_AVE ='$ave',
			 TOTAL_NO_OF_YEARS ='$tny',
			 DATE_OF_BIRTH ='$dob',
			 ADDRESS ='$address',
			 GENDER ='$gender'
			 	where STUDENT_ID = '$id' ";

		if (mysqli_query($conn, $sql)) {
			mysqli_query($conn, "INSERT into history_log (transaction,user_id,date_added) 
		VALUES ('Updated $id in the student list','$user',NOW() )");
		echo "<script>
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Data Successfuly updated.',
					}).then(() => {
						window.location.href = 'rms.php?page=student_p&id=" . $id . "';
					});
				</script>";
		} else {
			echo "<script>
					Swal.fire({
						icon: 'error',
						title: 'Failed',
						text: 'Failed to submit the form.',
					});
				</script>";
		}


		}
	}
mysqli_close($conn);

  ?>