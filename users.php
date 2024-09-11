<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'newaccount.php'; ?>

<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">List of Users</h3>
        </div>
        <div class="panel-body">
            <table id="students" class="table table-hover table-bordered">
                <thead>
                    <tr id="heads">
                        <th style="width:20%">No.</th>
                        <th style="width:20%">Name</th>
                        <th style="width:10%">User</th>
                        <th style="width:10%">Type</th>
                        <th style="width:30%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE STATUS = ''");
                    while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['USER_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['FIRSTNAME'] . " " . $row['LASTNAME']); ?></td>
                        <td><?php echo htmlspecialchars($row['USER']); ?></td>
                        <td><?php echo htmlspecialchars($row['USER_TYPE']); ?></td>
                        <td>
                            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#edit_user" data-id="<?php echo $row['USER_ID']; ?>" id="getUser">EDIT</a>
                            <a class="btn btn-danger text-white" href="#" onclick="deleteUser(<?php echo $row['USER_ID']; ?>)">DELETE</a>
                        </td>
                    </tr>
                    <?php
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="container frm-new">
        <div class="row main">
            <div class="main-login main-center">
                <h3>Add New Users</h3>
                <form method="post" action="add_user.php">
                    <div class="form-group">
                        <input type="text" class="form-control" style="text-transform: capitalize;" id="fname" name="fname" placeholder="Enter Firstname" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" style="text-transform: capitalize;" id="lname" name="lname" placeholder="Enter Lastname" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="type" id="sel1" required>
                            <option value="" disabled selected>Select User Type</option>
                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                            <option value="FACULTY">FACULTY</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="background-color: #28a745; border-color: #28a745;">Add</button>
                        <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel" style="background-color: #dc3545; border-color: #dc3545;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="post" action="update_user.php">
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="form-group">
                        <label for="editFname">Firstname</label>
                        <input type="text" class="form-control" id="editFname" name="fname" placeholder="Enter Firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="editLname">Lastname</label>
                        <input type="text" class="form-control" id="editLname" name="lname" placeholder="Enter Lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="editUser">Username</label>
                        <input type="text" class="form-control" id="editUser" name="user" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label for="editType">User Type</label>
                        <select class="form-control" name="type" id="editType" required>
                            <option value="" disabled>Select User Type</option>
                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                            <option value="FACULTY">FACULTY</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="background-color: #28a745; border-color: #28a745;">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #dc3545; border-color: #dc3545;">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function deleteUser(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: { action: 'delete', user_id: userId },
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire('Deleted!', 'User has been deleted.', 'success')
                        .then(() => location.reload());
                    } else {
                      Swal.fire('Deleted!', 'User has been deleted.', 'success')
                      .then(() => location.reload());
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Request failed.', 'error');
                }
            });
        }
    });
}

$(document).ready(function() {
    // Fetch user data and populate the modal when the "Edit" button is clicked
    $('#edit_user').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var userId = button.data('id'); // Extract info from data-* attributes

        $.ajax({
            url: 'get_user.php',
            type: 'POST',
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#editUserId').val(response.USER_ID);
                    $('#editFname').val(response.FIRSTNAME);
                    $('#editLname').val(response.LASTNAME);
                    $('#editUser').val(response.USER);
                    $('#editType').val(response.USER_TYPE);
                } else {
                    Swal.fire('Error!', 'Unable to fetch user details.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Request failed.', 'error');
            }
        });
    });

    // Handle form submission for editing user
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.trim() === 'success') {
                    Swal.fire('Updated!', 'User details have been updated.', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error!', 'Failed to update user details.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Request failed.', 'error');
            }
        });
    });
});
</script>