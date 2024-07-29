<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS (for styling) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom font styles */
        body {
            font-family: Arial, sans-serif; /* Font for the entire page */
        }
        .panel-title {
            font-size: 2rem; /* Larger font size for panel titles */
            font-weight: bold; /* Bold text for panel titles */
        }
        .table th, .table td {
            font-size: 1.25rem; /* Larger font size for table headers and cells */
        }
        .btn-info {
            font-size: 2rem; /* Font size for buttons */
        }
        .input-group input.form-control {
            font-size: 2rem; /* Font size for the input field */
        }
        .input-group-append .btn {
            font-size: 2rem; /* Font size for the search button */
        }
    </style>
</head>
<body>

    <!-- Search Form -->
    <form method="GET" action="">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group mb-3">
                        
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Students List -->
    <div class="container"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Students List</h3>
            </div> 
            <div class="panel-body">  
                <table id="students" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:10%">#</th>
                            <th style="width:10%">NO.</th>
                            <th style="width:10%">LRN NO.</th>
                            <th style="width:20%">Name</th>
                            <th style="width:10%">Gender</th>
                            <th style="width:10%">Curriculum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'db.php'; // Ensure your database connection is correct

                        // Get search term from URL parameters and handle the case when it's not set
                        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                        // Prepare SQL query with search filter
                        $sql = "SELECT student_info.*, program.PROGRAM
                                FROM student_info
                                LEFT JOIN program ON student_info.PROGRAM = program.PROGRAM_ID
                                WHERE student_info.LRN_NO LIKE '%$search%'
                                OR student_info.LASTNAME LIKE '%$search%'
                                OR student_info.FIRSTNAME LIKE '%$search%'
                                OR student_info.MIDDLENAME LIKE '%$search%'
                                OR program.PROGRAM LIKE '%$search%'";

                        // Execute the query and check for errors
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            die('Error in SQL query: ' . mysqli_error($conn));
                        }

                        // Fetch and display results
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['STUDENT_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['LRN_NO']); ?></td>
                                <td><?php echo htmlspecialchars($row['LASTNAME'] . ' ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME']); ?></td>
                                <td><?php echo htmlspecialchars($row['GENDER']); ?></td>
                                <td><?php echo htmlspecialchars($row['PROGRAM']); ?></td>
                                <td><a class="btn btn-info" href="form137.php?id=<?php echo htmlspecialchars($row['STUDENT_ID']); ?>" target="_blank"><i class="fa fa-fw fa-print"></i> Printable Report</a></td>
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

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#students").DataTable({
                "aaSorting": [[0, "asc"]]
            });
        });
    </script>
</body>
</html>
