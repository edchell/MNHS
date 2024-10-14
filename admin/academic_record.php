<?php
include('../includes/header.php');
include('include/topnav.php');
include('include/sidebar.php');
?>

<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<!-- multiple select row Datatable start -->
<div class="card-box mb-30">
    <div class="pd-20 d-flex align-items-center justify-content-between">
        <h4 class="text-blue h4">List of Students</h4>
    </div>
    <div class="pb-20">
        <table class="data-table table hover multiple-select-row nowrap">
        <thead>
            <tr>
                <th class="table-plus datatable-nosort">Name</th>
                <th>LRN No.</th>
                <th>Curriculum</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
    include '../includes/config.php';
    $sql=  mysqli_query($conn, "SELECT * FROM student_info order by INT_COURSE_COMP ");
    while($row = mysqli_fetch_assoc($sql)) {
      $sid = $row['STUDENT_ID'];
      $sql2=  mysqli_query($conn, "SELECT * FROM program WHERE PROGRAM_ID = '".$row['PROGRAM']."' ");
         while($row2 = mysqli_fetch_assoc($sql2)) {    
    ?>
      <tr>

        <td style="text-align:center"><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></td>
        <td style="text-align:center"><?php echo $row['LRN_NO'] ?></td>        
        <td style="text-align:center"><?php echo $row2['PROGRAM'] ?></td>
        <td style="text-align:center"><?php echo $row['INT_COURSE_COMP'] ?></td>
        
     
      <td style="text-align:center"> 
      <a href="db.php?page=academic_view&student_id=<?php echo urlencode($sid); ?>" class="btn btn-primary">View Record</a>


      <?php
    }
    } mysqli_close($conn);
      ?>
        </tbody>
    </table>
    </div>
</div>
<!-- multiple select row Datatable End -->
        </div>

<?php
include('../includes/footer.php');
?>