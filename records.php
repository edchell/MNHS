<?php
session_start();
include('auth.php');
?>
<h1 class="page-header">Student Records</h1>
<!-- <a class="btn btn-danger" href="javascript:void(0)" onclick="deleteAllRecords()">Delete All</a> -->
<div class="col-md-12">   
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Students List</h3>
        </div>
        <div class="panel-body">  
            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr id="heads">
                        <th style="width:10%">LRN NO.</th>
                        <th style="width:20%">Name</th>
                        <th style="width:10%">Gender</th>
                        <th style="width:10%">Address</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = mysqli_query($conn, "SELECT * FROM student_info");
                    while($row = mysqli_fetch_assoc($sql)) {
                    ?>
                        <tr>
                            <td><?php echo $row['LRN_NO'] ?></td>
                            <td><?php echo $row['LASTNAME'] . ' ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME'] ?></td>
                            <td><?php echo $row['GENDER'] ?></td>
                            <td><?php echo $row['ADDRESS'] ?></td>
                            <td>
                                <center>
                                    <a class="btn btn-info" href="rms.php?page=record&id=<?php echo $row['STUDENT_ID'] ?>">View Records</a>
                                </center>
                            </td>
                        </tr>
                    <?php
                    } mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    new DataTable('#example');

    function deleteAllRecords() {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action will permanently delete all records!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to delete records
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire('Deleted!', 'All records have been deleted.', 'success')
                            .then(() => {
                                location.reload(); // Refresh the page after deletion
                            });
                    } else {
                        Swal.fire('Error!', 'An issue occurred while deleting the records.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'An unexpected error occurred.', 'error');
                }
            });
        }
    });
}
</script>
