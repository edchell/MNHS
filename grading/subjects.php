<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects Management</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .panel-title {
            font-size: 1.75rem;
            font-weight: bold;
        }
        .table th, .table td {
            font-size: 1.25rem;
        }
        .btn-info {
            font-size: 1rem;
        }
        .input-group input.form-control {
            font-size: 1.25rem;
        }
        .input-group-append .btn {
            font-size: 1.25rem;
        }
        /* Custom button styles */
        .btn-submit {
            background-color: #ffcc99; /* Light orange background for submit button */
            border-color: #ffcc99; /* Light orange border for submit button */
            color: black; /* Text color for contrast */
        }

        .btn-cancel {
            background-color: #dc3545; /* Red background for cancel button */
            border-color: #dc3545; /* Red border for cancel button */
            color: white; /* White text color for cancel button */
        }
    </style>
</head>
<body>
<script>

<div class="container">
    
    
    <button style="float:right" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-plus"></i> Add New Subjects
    </button>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">List of Subjects</h3>
        </div> 
        <div class="panel-body">  
            <table id="students" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th style="width:20%">Subjects</th>
                        <th style="width:10%">Applicable For</th>
                        <th style="width:10%">Description</th>
                        <th style="width:10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include 'db.php';
                
                $sql = mysqli_query($conn, "SELECT *, `FOR` as para FROM subjects ORDER BY SUBJECT");
                while ($row = mysqli_fetch_assoc($sql)) {
                    $count = mysqli_num_rows($sql);
                ?>
                    <tr>
                        <input type="hidden" id="id<?php echo $row["SUBJECT_ID"] ?>" name="id" value="<?php echo $row['SUBJECT_ID'] ?>">
                        <td><input id="sub<?php echo $row["SUBJECT_ID"] ?>" name="subj" type="text" style="border:0px" value="<?php echo $row['SUBJECT'] ?>" readonly></td>
                        <td><input id="para<?php echo $row["SUBJECT_ID"] ?>" name="subj" type="text" style="border:0px" value="<?php echo $row['para'] ?>" readonly></td>
                        <td><input id="des<?php echo $row["SUBJECT_ID"] ?>" name="desc" type="text" style="border:0px;width:100%" value="<?php echo $row['DESCRIPTION'] ?>" readonly></td>
                        <td>
                            <center>
                                <a onclick="update_subject(<?php echo $row["SUBJECT_ID"] ?>)" class="btn btn-info">
                                    <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                                </a>
                            </center>
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

<!-- Modal for Adding New Subjects -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="head">Add New Subject</h3>
            </div>
            <div class="modal-body">
                <form id="subjectForm" method="post">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="sub">Subject</label>
                        <input type="text" class="form-control" id="sub" name="sub" placeholder="Enter Subject">
                    </div>
                    <div class="form-group">
                        <label for="para1">For</label>
                        <select name="f" class="form-control" id="para1">
                            <option value=""></option>
                            <option>All</option>
                            <?php
                            include 'db.php';
                            $sql = mysqli_query($conn, "SELECT * FROM program ORDER BY PROGRAM");
                            while ($row = mysqli_fetch_assoc($sql)) {
                                echo "<option value='" . $row['PROGRAM'] . "'>" . $row['PROGRAM'] . "</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <!-- Form fields here -->
                    
                    <div class="form-group">
                        <button type="button" class="btn btn-info custom-add" id="btn_add">Add</button>
                        <button type="button" class="btn btn-info custom-cancel" id="cancelButton">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Function to handle reset and hide modal
    function resetAndClose() {
        // Reset the form
        document.getElementById("subjectForm").reset();

        // Hide the modal
        $('#myModal').modal('hide');
    }

    // Attach the function to the Cancel button
    document.getElementById("cancelButton").addEventListener("click", resetAndClose);
</script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#students').DataTable({
            "paging": true,           // Enable pagination
            "searching": true,        // Enable search box
            "ordering": true,         // Enable column sorting
            "info": true,             // Display table info
            "pageLength": 10,         // Default number of rows per page
            "order": [[0, 'asc']]     // Default sorting (by first column)
        });

        // Function to handle the update subject button
        window.update_subject = function(i) {
            var para = $("#para" + i).val();
            $("#id").val($("#id" + i).val());
            $("#sub").val($("#sub" + i).val());
            $("#para1").val(para);
            $("#des").val($("#des" + i).val());
            $("#head").html("Update Subject");
            $("#btn_add").html("Update");
        }

        // Handle form submission
        $("#subjectForm").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: "POST",
                url: "process_subject.php", // Replace with your server-side script to process form data
                data: formData,
                success: function(response) {
                    // Handle success response
                    alert("Subject saved successfully.");
                    $('#myModal').modal('hide'); // Hide the modal
                    $('#students').DataTable().ajax.reload(); // Reload table data (if you're using AJAX for DataTable)
                },
                error: function() {
                    // Handle error response
                    alert("An error occurred while saving the subject.");
                }
            });
        });
    });
</script>

</body>
</html>
