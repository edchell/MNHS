<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <style>
        .btn-edit {
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            border: none;
            margin-right: 5px; /* Space between buttons */
        }

        .btn-edit:hover {
            background-color: #0056b3; /* Darker blue on hover */
            color: white;
        }

        .btn-delete {
            background-color: #dc3545; /* Red background */
            color: white; /* White text */
            border: none;
        }

        .btn-delete:hover {
            background-color: #c82333; /* Darker red on hover */
            color: white;
        }

        .btn-group {
            display: flex;
            justify-content: center; /* Center buttons in their cell */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-8">   
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List of Users</h3>
                </div> 
                <div class="panel-body">  
                    <table class="table table-bordered table-condensed" id="usersTable">
                        <thead>
                            <tr id="heads">
                                <th style="width:20%">Name</th>
                                <th style="width:10%">User</th>
                                <th style="width:10%">Type</th>
                                <th style="width:15%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db.php';
                            $sql = mysqli_query($conn, "SELECT * FROM user");
                            while($row = mysqli_fetch_assoc($sql)) {
                            ?>
                            <tr>
                                <td><?php echo $row['FIRSTNAME']." ".$row['LASTNAME'] ?></td>
                                <td><?php echo $row['USER'] ?></td>
                                <td><?php echo $row['USER_TYPE'] ?></td>
                                <td class="text-center">
                                    <!-- Actions button group -->
                                    <div class="btn-group">
                                        <a href="edit_user.php?id=<?php echo $row['USER_ID'] ?>" class="btn btn-edit">
                                            <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                        </a>
                                        <a data-toggle="modal" data-target="#delete_user" data-id="<?php echo $row['USER_ID'] ?>" id="getUser" class="btn btn-delete">
                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </a>
                                    </div>
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

        <h3>Add New Users</h3>
        <form method="post" action="add_user.php">
            <div class="form-group">
                <label for="lname" class="cols-sm-2 control-label">Last Name</label>
                <div class="cols-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" style="text-transform: capitalize;" id="lname" name="lname" placeholder="Enter Last Name" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="fname" class="cols-sm-2 control-label">First Name</label>
                <div class="cols-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" style="text-transform: capitalize;" id="fname" name="fname" placeholder="Enter First Name" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="user" class="cols-sm-2 control-label">User</label>
                <div class="cols-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="pwd" class="cols-sm-2 control-label">Password</label>
                <div class="cols-sm-4">
                    <div class="input-group">
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="type" class="cols-sm-2 control-label">User Type</label>
                <div class="cols-sm-4">
                    <div class="input-group">
                        <select class="form-control" name="type" id="type" required>
                            <option></option>
                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                            <option value="STAFF">STAFF</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel">
                <button class="btn btn-info">Add</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#usersTable").DataTable({
                "aaSorting": [[0, "asc"]],
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });

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
</body>
</html>
