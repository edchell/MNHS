<?php
include('../includes/header.php');
include('include/topnav.php');
include('include/sidebar.php');

// Check if the user is not logged in
if (!isset($_SESSION['FIRSTNAME']) && !isset($_SESSION['LASTNAME'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    include("404.php"); // Include your 404 page
    exit();
}
?>

<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<!-- multiple select row Datatable start -->
<div class="card-box mb-30">
    <div class="pd-20 d-flex align-items-center justify-content-between">
        <h4 class="text-blue h4">List of Students</h4>
        <button class="btn btn-primary" data-toggle="modal" data-target="#userModal"><i class="fa fa-user-plus"></i> Add Student</button>
    </div>
    <div class="pb-20">
        <table class="data-table table hover multiple-select-row nowrap">
        <thead>
            <tr>
                <th class="table-plus datatable-nosort">Name</th>
                <th>LRN No.</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
    include '../includes/config.php';
    $sql=  mysqli_query($conn, "SELECT * FROM student_info");
    while($row = mysqli_fetch_assoc($sql)) {
      $sid = $row['STUDENT_ID'];
    ?>
      <tr>

        <td><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></td>
        <td><?php echo $row['LRN_NO'] ?></td>        
        <td style="text-transform:capitalize;"><?php echo $row['GENDER'] ?></td>
        <td><?php echo $row['ADDRESS'] ?></td>
        
     
      <td> 
      <a href="db.php?page=student_profile&student_id=<?php echo urlencode($sid); ?>" class="btn btn-primary">View Profile</a>


      <?php
    } mysqli_close($conn);
      ?>
        </tbody>
    </table>
    </div>
</div>
<!-- multiple select row Datatable End -->
        </div>

        <!-- Add Student Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="student_add.php" method="POST">
                <div class="modal-body" style="max-height: 440px; overflow-y: auto;">
                  <h3 class="text-primary">Student Personal Details</h3>
                  <hr class="hr" />
                  <div class="d-flex -align-items-justify-content-between">
                      <div class="form-group mx-2">
                          <label for="firstname">First Name</label>
                          <input type="text" class="form-control" id="firstname" name="firstname" required>
                      </div>
                      <div class="form-group mx-2">
                          <label for="middlename">Middle Name</label>
                          <input type="text" class="form-control" id="middlename" name="middlename">
                      </div>
                      <div class="form-group mx-2">
                          <label for="lastname">Last Name</label>
                          <input type="text" class="form-control" id="lastname" name="lastname" required>
                      </div>
                  </div>
                  <div class="d-flex -align-items-justify-content-between">
                      <div class="form-group mx-2">
                          <label for="lrn_no">LRN No.</label>
                          <input type="text" class="form-control" id="lrn_no" name="lrn_no" required>
                      </div>
                      <div class="form-group mx-2">
                          <label for="gender">Gender</label>
                          <select class="custom-select col-12" id="gender" name="gender">
                            <option value="" selected disabled>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </select>
                      </div>
                      <div class="form-group mx-2">
                          <label for="dob">Date of Birth</label>
                          <input type="text" class="form-control date-picker" placeholder="Select Birtdate" id="dob" name="dob" required>
                      </div>
                  </div>
                  <div class="d-flex -align-items-justify-content-between">
                      <div class="form-group mx-2">
                          <label for="birth_place">Birth Place</label>
                          <input type="text" class="form-control" id="birth_place" name="birth_place" required>
                      </div>
                      <div class="form-group mx-2">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address" name="address" required>
                      </div>
                  </div>
                  <div class="d-flex -align-items-justify-content-between">
                      <div class="form-group mx-2">
                          <label for="parent_guardian">Parent/Guardian</label>
                          <input type="text" class="form-control" id="parent_guardian" name="parent_guardian" required>
                      </div>
                      <div class="form-group mx-2">
                          <label for="p_address">Parent/Guardian Address</label>
                          <input type="text" class="form-control" id="p_address" name="p_address" required>
                      </div>
                  </div>
                  <h3 class="text-primary">Intermediate Course Details</h3>
                  <hr class="hr" />
                  <div class="d-flex -align-items-justify-content-between">
                      <div class="form-group mx-2">
                          <label for="school_completed">School Completed</label>
                          <input type="text" class="form-control" id="school_completed" name="school_completed" required>
                      </div>
                      <div class="form-group mx-2">
                          <label for="school_year">School Year</label>
                          <input type="text" placeholder="FROM-TO" class="form-control" id="school_year" name="school_year" required>
                      </div>
                  </div>
                  <div class="d-flex -align-items-justify-content-between">
                      <div class="form-group mx-2">
                          <label for="gen_ave">General Average</label>
                          <input type="text" class="form-control" id="gen_ave" name="gen_ave" required>
                      </div>
                      <div class="form-group mx-2">
                          <label for="total_no_of_years">Total No. of Years</label>
                          <input type="text" class="form-control" id="total_no_of_years" name="total_no_of_years" required>
                      </div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include('../includes/footer.php');
?>