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
<style>
    .panel {
        max-width: 100%; /* Ensures it doesn't exceed the screen width */
        height: auto; /* Makes the height adjust automatically */
        overflow-y: auto; /* Adds scroll if the content overflows */
    }

    /* Ensure the container fills the viewport */
    .container {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .panel-body {
        max-height: 70vh; /* Adjust this value as needed */
        overflow-y: auto; /* Enables scrolling within the body */
    }

    /* Add padding and margins for mobile views */
    @media (max-width: 768px) {
        .panel {
            margin: 10px;
            padding: 15px;
        }
    }
</style>
<div class="container-fluid">
    <h1 class="page-header">Users</h1>
    <?php include 'newaccount.php'; ?>

    <div class="row">
        <!-- Left Column: User List -->
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List of Users</h3>
                </div>
                <div class="panel-body">
                    <table id="example" class="display" style="width:100%">
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

        <!-- Right Column: Add New User -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New User</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="newaccount.php">
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone No.</label>
                            <input type="text" maxlength="11" class="form-control" id="phone" name="phone" placeholder="Enter Phone No." required>
                        </div>
                        <div class="form-group">
                            <label for="user">Email</label>
                            <input type="email" class="form-control" id="user" name="user" placeholder="Enter Email" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" required>
                                <span class="input-group-addon">
                                    <input type="checkbox" id="showPwd">
                                    <label for="showPwd"><small>Show</small></label>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">User Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select User Type</option>
                                <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                <option value="FACULTY TEACHER">FACULTY TEACHER</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="reset" class="btn btn-danger" value="Cancel">
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit_user" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Manage Account</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="edit_user.php">
                        <div id="e_user"></div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // DataTable initialization
        new DataTable('#example');

        // Delete User Confirmation
        $(document).on('click', '.deleteUser', function () {
            const userId = $(this).data('id');
            if (confirm("Are you sure you want to delete this user?")) {
                $.post('user_delete.php', { id: userId }, function (response) {
                    alert(response);
                    location.reload();
                });
            }
        });

        // Show/Hide Password
        document.getElementById('showPwd').addEventListener('change', function () {
            const pwdInput = document.getElementById('pwd');
            pwdInput.type = this.checked ? 'text' : 'password';
        });
    });
</script>
