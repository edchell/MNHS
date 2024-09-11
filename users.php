
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
//     $(document).ready(function(){

//     $(document).on('click', '#getUser', function(e){
  
//      e.preventDefault();
  
//      var uid = $(this).data('id');      
 
//      $.ajax({
//           url: 'view_user.php',
//           type: 'POST',
//           data: 'id='+uid,
//           beforeSend:function()
// {
//  $("#e_user").html('Working on Please wait ..');
// },
// success:function(data)
// {
//    $("#e_user").html(data);
// },
//      })

//     });
// })
  </script>
     <?php include 'newaccount.php' ?>
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
                                        <a class="btn btn-primary" data-toggle="modal" data-target="#edit_user" data-id="<?php echo $row['USER_ID']; ?>" id="getUser"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                        <a class="btn btn-danger" data-id="<?php echo $row['USER_ID']; ?>" onclick="deleteUser(<?php echo $row['USER_ID']; ?>)"><i class="icon-copy fa fa-times-rectangle" aria-hidden="true"></i></a>
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
                            <form method="post">
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
                            <div class="form-group">
                                <label for="fname">Firstname:</label>
                                <input type="hidden" name="id" id="editUserId" value="<?php echo htmlspecialchars($row['USER_ID']); ?>">
                                <input type="text" class="form-control" id="editFname" name="fname" value="<?php echo htmlspecialchars($row['FIRSTNAME']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Lastname:</label>
                                <input type="text" class="form-control" id="editLname" name="lname" value="<?php echo htmlspecialchars($row['LASTNAME']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="user">User:</label>
                                <input type="text" class="form-control" id="editUser" name="user" value="<?php echo htmlspecialchars($row['USER_']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="editPwd" name="pwd" value="<?php echo htmlspecialchars($row['PASSWORD']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="type">User Type:</label>
                                <select class="form-control" name="type" id="editUserType" required>
                                    <option value="" disabled><?php echo htmlspecialchars($row['USER_TYPE']); ?></option>
                                    <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                    <option value="FACULTY">FACULTY</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
      
 <script type="text/javascript">
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
            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Define what happens on successful data submission
            xhr.onload = function () {
                if (xhr.status === 200) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then(() => {
                        // Optionally, you can refresh the page or remove the user row from the table
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the user.',
                        'error'
                    );
                }
            };

            // Define what happens in case of error
            xhr.onerror = function () {
                Swal.fire(
                    'Error!',
                    'Request failed.',
                    'error'
                );
            };

            // Set up our request
            xhr.send("action=delete&user_id=" + userId);
        }
    });
}

$(document).ready(function() {
            $(document).on('click', '#getUser', function() {
                var userId = $(this).data('id');
                $.ajax({
                    url: 'view_user.php',
                    type: 'POST',
                    data: { id: userId },
                    beforeSend: function() {
                        $("#e_user").html('Working on Please wait ..');
                    },
                    success: function(data) {
                        $("#e_user").html(data);
                    }
                });
            });

            $('#edit_user').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');

                $.ajax({
                    url: 'view_user.php',
                    type: 'POST',
                    data: { id: userId },
                    success: function(response) {
                        var user = JSON.parse(response);
                        var modal = $('#edit_user');
                        modal.find('#editUserId').val(user.USER_ID);
                        modal.find('#editFname').val(user.FIRSTNAME);
                        modal.find('#editLname').val(user.LASTNAME);
                        modal.find('#editUser').val(user.USER);
                        modal.find('#editUserType').val(user.USER_TYPE);
                    }
                });
            });
        });
</script>