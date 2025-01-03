<?php 

	include 'db.php';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$errors = array();

	if(preg_match("/\S+/", $_POST['sub']) === 0){
		$errors['sub'] = "* Subject is required.";
	}
	if(preg_match("/\S+/", $_POST['des']) === 0){
		$errors['des'] = "* Description is required.";
	}
	if(count($errors) === 0){


	$sub=$_POST['sub'];
	$des=$_POST['des'];
	$user= $_SESSION['ID'];
	if($_POST['id'] == ""){

	if ($sql=mysqli_query($conn, "INSERT into subjects (SUBJECT, DESCRIPTION) 
		VALUES ( '$sub', '$des' )")){
		mysqli_query($conn, "INSERT into history_log (transaction,user_id,status,date_added) 
		VALUES ('Added $sub in the subject list','$user','Add',NOW() )");
		echo "<script>
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'New Subject Added successfully.',
					}).then(() => {
						window.location.href = 'rms.php?page=subjects';
					});
				</script>";
	} else {
		echo "<script>
					Swal.fire({
						icon: 'error',
						title: 'Failed',
						text: 'New subject failed to record!" .$sql."',
					});
				</script>";
		unset($_POST);

	}
	}else{
		$id=$_POST['id'];
		$sql = "UPDATE subjects SET SUBJECT='$sub', DESCRIPTION='$des' WHERE SUBJECT_ID='$id'";
		mysqli_query($conn, "INSERT into history_log (transaction,user_id,status,date_added) 
		VALUES ('Updated $id in the subject list','$user','Update',NOW() )");

		if (mysqli_query($conn, $sql)) {
		echo "<script>
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Subject Successfully Updated.',
					}).then(() => {
						window.location.href = 'rms.php?page=subjects';
					});
				</script>";
		} else {
    echo "Error updating record: " . mysqli_error($conn);
		}
	}
}else{
	echo "<script>setTimeout(function(){	$('.erlert').hide()  }, 3000);</script>";
}

}

	mysqli_close($conn);

 ?>