<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- jQuery (necessary for DataTables and Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Your Custom JavaScript -->
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
</script>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">User Archived</h3>
        </div>
        <div class="panel-body">
            <table id="students" class="table table-bordered table-condensed">
                <thead>
                    <tr id="heads">
                        <th style="width:10%; text-align:center;">No.</th>
                        <th style="width:30%; text-align:center;">Name</th>
                        <th style="width:10%; text-align:center;">User</th>
                        <th style="width:20%; text-align:center;">Type</th>
                        <th style="width:20%; text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql = mysqli_query($conn, "SELECT * FROM user");
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $sid = $row['USER_ID'];
                        $sql2 = mysqli_query($conn, "SELECT * FROM program WHERE PROGRAM_ID = '" . $row['PROGRAM'] . "' ");
                        while ($row2 = mysqli_fetch_assoc($sql2)) {
                    ?>
                    <tr>
                        <td><?php echo $row['USER_ID'] ?></td>
                        <td><?php echo $row['FIRSTNAME'] . " " . $row['LASTNAME'] ?></td>
                        <td><?php echo $row['USER'] ?></td>
                        <td><?php echo $row['USER_TYPE'] ?></td>
                        <td style="text-align:center">
                            <a
                                style="
                                    background-color: #007bff; /* Custom blue background */
                                    color: white; /* White text */
                                    padding: 10px 20px; /* Padding around text */
                                    font-size: 16px; /* Font size */
                                    border: none; /* Remove border */
                                    border-radius: 5px; /* Rounded corners */
                                    cursor: pointer; /* Pointer cursor on hover */
                                    transition: background-color 0.3s; /* Smooth transition on hover */
                                "
                                class="btn btn-default"
                                data-toggle="modal"
                                data-target="#view-modal"
                                data-id="<?php echo $sid ?>"
                                id="getUser"
                            >
                                Unarchived
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
