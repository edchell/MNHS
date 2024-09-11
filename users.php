<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#getUser', function(e) {
            e.preventDefault();

            var uid = $(this).data('id');      

            $.ajax({
                url: 'view_user.php',
                type: 'POST',
                data: { id: uid },
                beforeSend: function() {
                    $("#e_user").html('Working on Please wait ..');
                },
                success: function(data) {
                    $("#e_user").html(data);
                },
                error: function() {
                    $("#e_user").html('An error occurred while fetching user data.');
                }
            });
        });
    });

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
                            Swal.fire('Deleted!', 'User has been deleted.', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', 'There was an error deleting the user.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Request failed.', 'error');
                    }
                });
            }
        });
    }
</script>

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
                            <td><?php echo $row['USER_ID']; ?></td>
                            <td><?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?></td>
                            <td><?php echo $row['USER']; ?></td>
                            <td><?php echo $row['USER_TYPE']; ?></td>
                            <td>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#edit_user" data-id="<?php echo $row['USER_ID']; ?>" id="getUser">
                                    <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-danger" data-id="<?php echo $row['USER_ID']; ?>" onclick="deleteUser(<?php echo $row['USER_ID']; ?>)">
                                    <i class="icon-copy fa fa-times-rectangle" aria-hidden="true"></i>
                                </a>
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
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" style="text-transform: capitalize;" id="fname" name="fname" placeholder="Enter Firstname" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" style="text-transform: capitalize;" id="lname" name="lname" placeholder="Enter Lastname" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <select class="form-control" name="type" id="sel1" required>
                                    <option></option>
                                    <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                    <option value="FACULTY">FACULTY</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" style="background-color: #28a745; border-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Add</button>
                        <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel" style="background-color: #dc3545; border-color: #dc3545; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_user" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Account</h4>
            </div>
            <div class="modal-body" id="e_user"> 
                <!-- Content will be loaded here from the AJAX request -->
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
            </div> 
        </div>
    </div>
</div>
