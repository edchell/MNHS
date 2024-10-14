<?php
include('../includes/header.php');
include('include/topnav.php');
include('include/sidebar.php');

// Check if the user is not logged in
if (!isset($_SESSION['FIRSTNAME']) && !isset($_SESSION['LASTNAME'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    include("404.php"); // Include your 404 page
    exit();
}
?>

<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<!-- multiple select row Datatable start -->
<div class="card-box mb-30">
    <div class="pd-20 d-flex align-items-center justify-content-between">
        <h4 class="text-blue h4">List of Users</h4>
        <button class="btn btn-primary" data-toggle="modal" data-target="#userModal"><i class="fa fa-user-plus"></i> Add User</button>
    </div>
    <div class="pb-20">
        <table class="data-table table hover multiple-select-row nowrap">
        <thead>
            <tr>
                <th class="table-plus datatable-nosort">Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch users from the database
            include('../includes/config.php'); // Ensure your database connection is included

            $query = "SELECT `USER_ID`, `LASTNAME`, `FIRSTNAME`, `USER`, `USER_TYPE` FROM `user`"; // Ensure you select the user USER_ID
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td class='table-plus'>{$row['FIRSTNAME']} {$row['LASTNAME']}</td>
                        <td>{$row['USER']}</td>
                        <td>{$row['USER_TYPE']}</td>
                        <td>
                            <button class='btn btn-warning' onclick='openEditModal({$row['USER_ID']}, \"{$row['FIRSTNAME']}\", \"{$row['LASTNAME']}\", \"{$row['USER']}\", \"{$row['USER_TYPE']}\")'>Edit</button>
                            <button class='btn btn-danger' onclick='deleteUser({$row['USER_ID']})'>Delete</button>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
    </div>
</div>
<!-- multiple select row Datatable End -->

                     <!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="users_code.php" method="post">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="administrator">Administrator</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addUser()" id="submitUser">Add User</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="post" action="users_update.php">
                    <input type="hidden" name="USER_ID" id="editUserId">
                    <div class="form-group">
                        <label for="editFirstname">Firstname</label>
                        <input type="text" class="form-control" id="editFirstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastname">Lastname</label>
                        <input type="text" class="form-control" id="editLastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserType">User Type</label>
                        <input type="text" class="form-control" id="editUserType" name="usertype" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitUser">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Edit User Modal -->

				</div>

<script>
document.getElementById('submitUser').addEventListener('click', function() {
    // Function to check for XSS
    function containsXSS(input) {
        const xssRegex = /<[^>]*>/; // Simple regex to detect HTML tags
        return xssRegex.test(input);
    }

    // Get form values
    const lastname = document.getElementById('lastname').value;
    const firstname = document.getElementById('firstname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;

    // Check for XSS
    if (
        containsXSS(lastname) || 
        containsXSS(firstname) || 
        containsXSS(email) || 
        containsXSS(password)
    ) {
        Swal.fire({
            icon: 'error',
            title: 'XSS Tags Detected!',
            text: 'Please ensure that no harmful HTML tags are present in the input fields.',
        });
    } else {
        // Proceed with sanitizing and processing the input
        const sanitizedLastname = sanitizeInput(lastname);
        const sanitizedFirstname = sanitizeInput(firstname);
        const sanitizedEmail = sanitizeInput(email);
        const sanitizedPassword = sanitizeInput(password);
        
        // Here you can send the sanitized data to the server or handle it as needed
        console.log({ sanitizedLastname, sanitizedFirstname, sanitizedEmail, sanitizedPassword, role });
        
        // Optionally, reset the form or close the modal
        // document.getElementById('addUserForm').reset();
        // $('#userModal').modal('hide');
    }
});

// Function to sanitize input
function sanitizeInput(input) {
    const tempDiv = document.createElement('div');
    tempDiv.textContent = input;
    return tempDiv.innerHTML;
}

function addUser() {
    const role = document.getElementById('role').value;
    const lastname = document.getElementById('lastname').value;
    const firstname = document.getElementById('firstname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (role && lastname && firstname && email && password) {
        const formData = new FormData();
        formData.append('role', role);
        formData.append('lastname', lastname);
        formData.append('firstname', firstname);
        formData.append('email', email);
        formData.append('password', password);

        fetch('users_code.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            document.getElementById('addUserForm').reset();
            $('#userModal').modal('hide');
            alert('User added successfully!');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the user.');
        });
    } else {
        alert('Please fill in all fields.');
    }
}

// Example of sanitizing input before form submission
document.getElementById('editUserForm').onsubmit = function(event) {
    const firstname = document.getElementById('editFirstname').value;
    const lastname = document.getElementById('editLastname').value;
    const email = document.getElementById('editEmail').value;
    const userType = document.getElementById('editUserType').value;

    // Sanitize inputs
    document.getElementById('editFirstname').value = sanitizeInput(firstname);
    document.getElementById('editLastname').value = sanitizeInput(lastname);
    document.getElementById('editEmail').value = sanitizeInput(email);
    document.getElementById('editUserType').value = sanitizeInput(userType);
};

function openEditModal(id, firstname, lastname, email, userType) {
    // Set the modal fields with user data
    document.getElementById('editUserId').value = id;
    document.getElementById('editFirstname').value = firstname;
    document.getElementById('editLastname').value = lastname;
    document.getElementById('editEmail').value = email;
    document.getElementById('editUserType').value = userType;

    // Show the modal
    $('#editUserModal').modal('show');
}

function deleteUser(userId) {
    // Confirm deletion
    if (confirm('Are you sure you want to delete this user?')) {
        fetch('users_delete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ USER_ID: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('User deleted successfully.');
                location.reload(); // Refresh the page
            } else {
                alert('Error deleting user: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>
<?php
include('../includes/footer.php');
?>