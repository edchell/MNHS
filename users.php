

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- jQuery (required for the AJAX request) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        // Handle form submission in the edit_user modal
        $(document).on('submit', '#edit_user_form', function(e) {
            e.preventDefault(); // Prevent the default form submission
            
            var form = $(this);
            var formData = form.serialize(); // Serialize form data

            $.ajax({
                url: form.attr('action'), // Form action URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle successful response
                    alert('User details updated successfully.');
                    $('#edit_user').modal('hide'); // Hide the modal
                    // Optionally, reload the page or update the table
                    location.reload();
                },
                error: function() {
                    // Handle error response
                    alert('An error occurred while updating user details.');
                }
            });
        });

        // Optional: Handle click event for opening the modal and populating it with data
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
                    $("#e_user").html('An error occurred while fetching the user data.');
                }
            });
        });
    });
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
      <tr id="heads">
      <th style="width:10%">#.</th>
        <th style="width:20%">Name</th>
        <th style="width:10%">User</th>
        <th style="width:10%">Type</th>
        <th style="width:10%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'db.php';

    // Fetch users from the database
    $sql = mysqli_query($conn, "SELECT * FROM user");

    // Check for database query errors
    if (!$sql) {
        die("Query failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($sql)) {
    ?>
        <tr>
            <td><?php echo $row['USER_ID']; ?></td>
            <td><?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME']; ?></td>
            <td><?php echo $row['USER']; ?></td>
            <td><?php echo $row['USER_TYPE']; ?></td>
            <td>
                <a data-toggle="modal" class="btn btn-primary" data-target="#edit_user" data-id="<?php echo $row['USER_ID']; ?>" id="getUser">
                    <span style="color: white;">Edit</span>
                </a>
                <a href="#" class="btn btn-danger btn-delete" data-id="<?php echo $row['USER_ID']; ?>">
                    <span style="color: white;">Delete</span>
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
        
      <style>
    /* Style for Add New Users button */
    .btn-add-new-user {
        background-color: blue; /* Blue background color */
        color: white;           /* White text color */
        border: none;           /* Remove border */
        font-size: 16px;        /* Font size */
        font-weight: bold;      /* Bold text */
        padding: 10px 20px;     /* Padding for better appearance */
        border-radius: 5px;     /* Rounded corners */
        cursor: pointer;        /* Pointer cursor on hover */
    }

    /* Optional: Style for button on hover */
    .btn-add-new-user:hover {
        opacity: 0.8; /* Slightly reduce opacity on hover */
    }
</style>
     

      <div class="row main">
    <div class="main-login main-center">
        <h3 class="page-header">
            <button style="float:right" type="button" class="btn btn-add-new-user" data-toggle="modal" data-target="#myModal">
                <i class="glyphicon glyphicon-plus"></i> Add New Users
            </button>
        
    </div>
</div>

<head>
    <!-- Other head elements -->
    <style>
        /* Place the CSS styles here */
    </style>
</head>

                 

<style>
  /* Style for the Save button */
  .btn-save {
    background-color: #4CAF50; /* Green background color */
    color: white; /* White text color */
    border: none; /* Remove border */
    font-size: 20px; /* Font size */
    font-weight: bold; /* Bold text */
    padding: 10px 20px; /* Padding for better appearance */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth background color transition */
  }

  /* Optional: Style for Save button on hover */
  .btn-save:hover {
    background-color: #45a049; /* Darker green on hover */
  }

  /* Style for the Close button */
  .btn-close {
    background-color: #f44336; /* Red background color */
    color: white; /* White text color */
    border: none; /* Remove border */
    font-size: 20px; /* Font size */
    font-weight: bold; /* Bold text */
    padding: 10px 20px; /* Padding for better appearance */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth background color transition */
  }

  /* Optional: Style for Close button on hover */
  .btn-close:hover {
    background-color: #d32f2f; /* Darker red on hover */
  }
</style>


<!-- Modal for Adding New User -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="add_user.php">
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" required>
                    </div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="user">Username</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                        <label for="type">User Type</label>
                        <select class="form-control" name="type" id="type" required>
                            <option></option>
                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                            <option value="STAFF">STAFF</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-save">Save</button>
                        <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="edit_user" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Account</h4>
            </div>
            <div class="modal-body">
                <form class="form-group" method="POST" action="edit_user.php">
                    <div class="container">
                        <div id="e_user">
                            <!-- Dynamic content will be loaded here -->
                        </div>
                    </div>
            </div>       
            <div class="modal-footer">
                <button type="submit" class="btn btn-save">Save</button>
                </form>
                <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>


      
 <script type="text/javascript">
        $(function() {
            $("#students").dataTable(
        { "aaSorting": [[ 0, "asc" ]] }
      );
        });
    </script>
    <script>
$(document).ready(function() {
    // Handle delete button click
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault(); // Prevent default action
        
        var userId = $(this).data('id'); // Get user ID from button's data attribute
        
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX request to delete the user
                $.ajax({
                    url: 'delete_user.php', // URL to your PHP script handling deletion
                    type: 'POST',
                    data: { id: userId }, // Send the user ID to the server
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'User has been deleted.',
                            'success'
                        );
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the user.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        // Handle form submission for adding a new user
        $('#btn-save-user').click(function(e) {
            e.preventDefault(); // Prevent default form submission

            var form = $(this).closest('form');
            var formData = form.serialize(); // Serialize form data

            $.ajax({
                url: form.attr('action'), // Form action URL (add_user.php)
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Show success message using SweetAlert2
                    Swal.fire({
                        title: 'Success!',
                        text: 'User added successfully.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500 // Close alert after 1.5 seconds
                    });

                    // Optionally, reload the page or update the table
                    $('#myModal').modal('hide'); // Hide the modal
                    location.reload(); // Reload the page to reflect changes
                },
                error: function() {
                    // Show error message using SweetAlert2
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while adding the user.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>


