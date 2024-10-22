<?php
include('auth.php');
?>
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
            }
        });
    });
});
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
                        <th style="width:20%">Name</th>
                        <th style="width:10%">User</th>
                        <th style="width:10%">Type</th>
                        <th style="width:20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE STATUS = ''");
                    while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['FIRSTNAME'] . " " . $row['LASTNAME']); ?></td>
                            <td><?php echo htmlspecialchars($row['USER']); ?></td>
                            <td><?php echo htmlspecialchars($row['USER_TYPE']); ?></td>
                            <td>
                                <a data-toggle="modal" data-target="#edit_user" data-id="<?php echo $row['USER_ID']; ?>" id="getUser">
                                    <i class="fa fa-pencil-square" aria-hidden="true"></i> edit
                                </a>
                                <a href="#" class="text-danger deleteUser" data-id="<?php echo $row['USER_ID']; ?>">
                                    <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
                <form method="post" action="newaccount.php"> <!-- Specify the action URL -->
                    <div class="form-group">
                        <label for="lname" class="cols-sm-2 control-label">Last Name</label>
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" style="text-transform: capitalize;" id="lname" name="lname" placeholder="Enter Lastname" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="cols-sm-2 control-label">First Name</label>
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" style="text-transform: capitalize;" id="fname" name="fname" placeholder="Enter Firstname" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user" class="cols-sm-2 control-label">Email</label>
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="email" class="form-control" id="user" name="user" placeholder="Enter Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pwd" class="cols-sm-2 control-label">Password</label>
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" required>
                                <div class="input-group-append">
                                    <input type="checkbox" id="showPwd" style="margin-left: 10px;">
                                    <label for="showPwd" style="margin-left: 5px;"><small>Show Password</small></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="cols-sm-2 control-label">User Type</label>
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <select class="form-control" name="type" id="type" required>
                                    <option value="">Select User Type</option>
                                    <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                    <option value="STAFF">STAFF</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel">
                        <button type="submit" class="btn btn-info">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_user" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Account</h4>
                </div>
                <div class="modal-body">
                    <form class="form-group" method="POST" action="edit_user.php">
                        <div class="container">
                            <div id="e_user"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Save</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $("#students").dataTable({
                "aaSorting": [[0, "asc"]]
            });
        });

        $(document).on('click', '.deleteUser', function() {
        const userId = $(this).data('id');
        if (confirm("Are you sure you want to delete this user?")) {
            $.post('user_delete.php', { id: userId }, function(response) {
                alert(response);
                location.reload(); // Refresh the page to see the changes
            });
        }
    });

    document.getElementById('showPwd').addEventListener('change', function() {
        const pwdInput = document.getElementById('pwd');
        pwdInput.type = this.checked ? 'text' : 'password';
    });
    </script>
</div>
