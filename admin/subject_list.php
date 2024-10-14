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
        <h4 class="text-blue h4">List of Subjects</h4>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModal">
            <i class="fa fa-user-plus"></i> Add Subject
        </button>
    </div>

    <!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="subject_add.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" name="subject" id="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description" id="description" required>
                    </div>
                    <!-- FOR Field (Program Selection) -->
                    <div class="form-group">
                        <label for="para">FOR</label>
                        <select name="para" class="form-control" id="para1" required>
                            <option value="" disabled selected>Select Program</option>
                            <option value="All">All</option>
                            <?php
                            include '../includes/config.php';
                            $sql = mysqli_query($conn, "SELECT * FROM program ORDER BY PROGRAM");
                            while ($row = mysqli_fetch_assoc($sql)) {
                            ?>
                                <option value="<?php echo $row['PROGRAM']; ?>">
                                    <?php echo $row['PROGRAM']; ?>
                                </option>
                            <?php 
                            } 
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="pb-20">
        <table class="data-table table hover multiple-select-row nowrap">
        <thead>
            <tr>
                <th class="table-plus datatable-nosort">Subjects</th>
                <th>Applicable For</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
    include '../includes/config.php';
    $sql=  mysqli_query($conn, "SELECT *, `FOR` as para FROM subjects ORDER BY SUBJECT");
    while($row = mysqli_fetch_assoc($sql)) {
      $count = mysqli_num_rows($sql);
    ?>
      <tr>

        <td style="text-align:center"><?php echo $row['SUBJECT'] ?></td>
        <td style="text-align:center"><?php echo $row['para'] ?></td>        
        <td style="text-align:center"><?php echo $row['DESCRIPTION'] ?></td>
        <td style="text-align:center">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $row['SUBJECT_ID']; ?>">Edit</button>
        </td>
      
      <!-- Modal -->
    <div class="modal fade" id="editModal<?php echo $row['SUBJECT_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="subject_update.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="subject_id" value="<?php echo $row['SUBJECT_ID']; ?>">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" value="<?php echo $row['SUBJECT']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" value="<?php echo $row['DESCRIPTION']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="para">FOR</label>
                            <select name="para" class="form-control" id="para1">
                                <option value="" disabled><?php echo $row['para']; ?></option> <!-- Display current value as default -->
                                <option value="All">All</option>
                                <?php
                                $sql2 = mysqli_query($conn, "SELECT * FROM program ORDER BY PROGRAM");
                                while ($row2 = mysqli_fetch_assoc($sql2)) {
                                ?>
                                    <option value="<?php echo $row2['PROGRAM']; ?>">
                                        <?php echo $row2['PROGRAM']; ?>
                                    </option>
                                <?php 
                                } 
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

      <?php
    }
mysqli_close($conn);
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