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
        body {
            font-family: Arial, sans-serif;
        }
        .panel-title {
            font-size: 2.75rem;
            font-weight: bold;
        }
        .table th, .table td {
            font-size: 1.25rem;
        }
        .btn-info {
            font-size: 2rem;
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
    $(document).ready(function(){
        $(document).on('click', '#getUser', function(e){
            e.preventDefault();
            var uid = $(this).data('id');      
            $.ajax({
                url: 'view_students.php',
                type: 'POST',
                data: 'id='+uid,
                beforeSend:function() {
                    $("#content").html('Working on Please wait ..');
                },
                success:function(data) {
                    $("#content").html(data);
                },
            })
        });

        // Initialize DataTables only if it hasn't been initialized
        if (!$.fn.DataTable.isDataTable('#students')) {
            $('#students').DataTable({ "aaSorting": [[ 2, "asc" ]] });
        }
    });
</script>
<?php
include 'newstudent.php';
?>

<button style="float:right" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
    <i class="glyphicon glyphicon-plus"></i> New Entry
</button>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Students</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post">
                    <fieldset>
                        <div class="container">
                            <div class="col-md-12" style="width:70%;border-bottom:1px solid #333">
                                <h4><b>Student's Personal Details </b></h4>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-4">
                                <br>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label" for="lrn">LRN Number</label>
                                    <div class="col-xs-6">
                                        <input id="lrn" name="lrn" type="text" placeholder="Enter LRN " maxlength="12" class="form-control input-xs" required="">
                                    </div>
                                </div>

                                <!-- Prepended text-->
                                <div class="form-group">
                                    <label class="col-xs-4 control-label" for="name">Name</label>
                                    <div class="col-xs-8">
                                        <div class="input-group">
                                            <input id="name" class="form-control input-xs"
                                                style="text-transform: capitalize;" name="lname" placeholder="Lastname" type="text" required="">
                                            <input id="name" class="form-control input-xs"
                                                style="text-transform: capitalize;" name="fname" placeholder="Firstname" type="text" required="">
                                            <input id="name" class="form-control input-xs"
                                                style="text-transform: capitalize;" name="mname" placeholder="Middlename" type="text" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-4 control-label" for="gender">Gender</label>
                                    <div class="col-xs-4">
                                        <select id="gender" name="gender" class="form-control input-xs">
                                            <option value="MALE">Male</option>
                                            <option value="FEMALE">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-4 control-label" for="address">Birth Place</label>
                                    <div class="col-xs-8">
                                        <div class="input-group">
                                            <input id="address" class="form-control"
                                                style="text-transform: capitalize;" name="bp" placeholder="Birth Place" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <br>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="dob">Date of Birth</label>
                                    <div class="col-xs-7">
                                        <input id="dob" name="dob" type="date" placeholder="YYYY-MM-DD" class="form-control input-md" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="pob">ADDRESS</label>
                                    <div class="col-xs-7">
                                        <input id="pob" name="pob" type="text" style="text-transform: capitalize;" placeholder="Enter Student Address" class="form-control input-xs" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="pg">Parent/Guardian</label>
                                    <div class="col-xs-7">
                                        <div class="input-group">
                                            <input id="pg" name="pg" class="form-control" style="text-transform: capitalize;" placeholder="Enter Full Name" type="text" required="">
                                            <input id="pg" name="pg_add" class="form-control" style="text-transform: capitalize;" placeholder="Enter Address" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="width:70%;border-bottom:1px solid #333">
                                <h4><b>Intermediate Course Details </b></h4>
                            </div>
                            <br>
                            <br>
                            <div class="col-md-12">
                                <br>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="icc">Intermediate Course</label>
                                    <br>
                                    <div class="col-xs-6">
                                        <input id="icc" name="icc" type="text" placeholder="Enter Course" class="form-control input-xs" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="sy">School Year</label>
                                    <br>
                                    <div class="col-xs-6">
                                        <input id="sy" name="sy" type="text" placeholder="FROM-TO" class="form-control input-xs" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="tn">Total Number Of Years</label>
                                    <br>
                                    <div class="col-xs-6">
                                        <input id="tn" name="tny" type="number" style="width:100px;text-align:right" class="form-control input-xs" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="ave">General Average</label>
                                    <div class="col-xs-6">
                                        <input id="ave" name="ave" type="integer" style="width:100px;text-align:right" class="form-control input-xs" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="width:70%;border-bottom:1px solid #333">
                                <h4><b>Program Enrolled </b></h4>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-xs-4 control-label" for="Prog">Curriculum</label>
                                <div class="col-xs-4">
                                    <select id="prog" name="prog" class="form-control input-xs" required="">
                                        <option></option>
                                        <?php
                                        include 'db.php';
                                        $sql = mysqli_query($conn,"SELECT * from program Order by PROGRAM ASC");
                                        while($row=mysqli_fetch_assoc($sql)){
                                        ?>
                                        <option value="<?php echo $row['PROGRAM_ID'] ?>"><?php echo $row['PROGRAM'] ?></option>
                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <input type="reset" class="btn btn-cancel" id="reset" name="reset" value="Cancel">
                    <button class="btn btn-submit">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Students List</h3>
        </div>
        <div class="panel-body">
           
                <thead>
                    <tr id="heads">
                        <th style="width:10%;text-align:center">LRN NO.</th>
                        <th style="width:30%;text-align:center">Name</th>
                        <th style="width:20%;text-align:center">Curriculum</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';
                    $sql=  mysqli_query($conn, "SELECT * FROM student_info order by LASTNAME ");
                    while($row = mysqli_fetch_assoc($sql)) {
                        $sid = $row['STUDENT_ID'];
                        $sql2=  mysqli_query($conn, "SELECT * FROM program WHERE PROGRAM_ID = '".$row['PROGRAM']."' ");
                        while($row2 = mysqli_fetch_assoc($sql2)) {
                    ?>
                    <tr>
                        <td><?php echo $row['LRN_NO'] ?></td>
                        <td><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></td>
                        <td style="text-align:center"><?php echo $row2['PROGRAM'] ?></td>
                        <td style="text-align:center"> 
                            <a class="btn btn-info" data-toggle="modal" data-target="#view-modal" data-id="<?php echo $sid ?>" id="getUser">View Profile</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                    <i class=""></i> PROFILE
                </h4>
            </div>
            <div id="content">
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
