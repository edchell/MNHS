<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
include 'newstudent.php';
?>

<div class="col-md-12">        
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">User Archived</h3>
        </div>
        <div class="panel-body">
            <table id="students" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="width:10%; text-align:center;">No.</th>
                        <th style="width:30%; text-align:center;">Name</th>
                        <th style="width:10%; text-align:center;">User</th>
                        <th style="width:20%; text-align:center;">Type</th>
                        <th style="width:20%; text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'boxes.php';
                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE STATUS = 'Archived' ORDER BY USER_ID");
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $sid = $row['USER_ID'];
                    ?>
                    <tr>
                        <td><?php echo $row['USER_ID']; ?></td>
                        <td><?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?></td>
                        <td><?php echo $row['USER']; ?></td>
                        <td><?php echo $row['USER_TYPE']; ?></td>
                        <td><center><a class="btn btn-primary text-white" href="#" data-id="<?php echo $row['USER_ID']; ?>" id="getUser" onclick="unarchiveUser(<?php echo $row['USER_ID']; ?>)">Unarchive</a></center></td>
                    </tr>
                    <?php } mysqli_close($conn); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $("#students").DataTable({
        "aaSorting": [[0, "asc"]], // Default sorting by the first column (index starts at 0)
        "paging": true,           // Enable pagination
        "searching": true,        // Enable search box
        "ordering": true,         // Enable column sorting
        "info": true              // Display information (e.g., showing 1 to 10 of 50 entries)
    });

    // Handle click event to fetch student data
    $(document).on('click', '#getUser', function(e) {
        e.preventDefault();

        var uid = $(this).data('id');

        $.ajax({
            url: 'view_students.php',
            type: 'POST',
            data: { id: uid },
            beforeSend: function() {
                $("#content").html('Working on Please wait ..');
            },
            success: function(data) {
                $("#content").html(data);
            }
        });
    });
});

function unarchiveUser(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, unarchive it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create an AJAX request
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: { action: 'unarchive', user_id: userId },
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire(
                            'Unarchived!',
                            'User has been unarchived.',
                            'success'
                        ).then(() => {
                            // Refresh the page or update the table
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Unarchived!',
                            'User has been unarchived.',
                            'success'
                        ).then(() => {
                            // Refresh the page or update the table
                            location.reload();
                        });
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Request failed.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>