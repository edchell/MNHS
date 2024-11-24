<?php
include('auth.php');
?>
<script>
    $(document).ready(function(){

    $(document).on('click', '#getUser', function(e){
  
     e.preventDefault();
  
     var uid = $(this).data('id');      
 
     $.ajax({
          url: 'view_students.php',
          type: 'POST',
          data: 'id='+uid,
          beforeSend:function()
{
 $("#content").html('Working on Please wait ..');
},
success:function(data)
{
   $("#content").html(data);
},
     })

    });
})
  </script>
   <?php
  include 'grade10_new.php';
  ?>

          <h1 class="page-header">STUDENTS <button style="float:right" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
      <i class="glyphicon glyphicon-plus"></i> New Entry</button></h1>
  
 

      <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Students</h4>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <form class="form-horizontal" method="post">
                    <fieldset>
                        <div class="container">
                            <div class="col-md-12" style="width:70%;border-bottom:1px solid #333">
                                <h4><b>Student's Personal Details </b></h4>
                            </div>
                            <br><br>
                            <div class="col-md-4">
                                <br>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label" for="lrn">LRN Number</label>
                                    <div class="col-xs-6">
                                        <input id="lrn" name="lrn" type="text" placeholder="Enter LRN " maxlength="12" class="form-control input-xs" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label" for="name">Name</label>
                                    <div class="col-xs-8">
                                        <div class="input-group">
                                            <input id="name" class="form-control input-xs" style="text-transform: capitalize;margin-bottom:5px;" name="lname" placeholder="Lastname" type="text" required>
                                            <input id="name" class="form-control input-xs" style="text-transform: capitalize;margin-bottom:5px;" name="fname" placeholder="Firstname" type="text" required>
                                            <input id="name" class="form-control input-xs" style="text-transform: capitalize;" name="mname" placeholder="Middlename" type="text">
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
                                            <input id="address" class="form-control" style="text-transform: capitalize;" name="bp" placeholder="Birth Place" type="text" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <br><br><br>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="dob">Date of Birth</label>
                                    <div class="col-xs-7">
                                        <input id="dob" name="dob" type="date" placeholder="YYYY-MM-DD" class="form-control input-md" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="pob">ADDRESS</label>
                                    <div class="col-xs-7">
                                        <input id="pob" name="pob" type="text" style="text-transform: capitalize;" placeholder="Enter Student Address" class="form-control input-xs" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="pg">Parent/Guardian</label>
                                    <div class="col-xs-7">
                                        <div class="input-group">
                                            <input id="pg" name="pg" class="form-control" style="text-transform: capitalize;margin-bottom:5px;" placeholder="Enter Full Name" type="text" required>
                                            <input id="pg" name="pg_add" class="form-control" style="text-transform: capitalize;" placeholder="Enter Address" type="text" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="width:70%;border-bottom:1px solid #333">
                                <h4><b>Intermediate Course Details </b></h4>
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <br>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="icc">Intermediate Course Completed</label>
                                    <br>
                                    <div class="col-xs-6">
                                        <input id="icc" name="icc" type="text" style="text-transform: capitalize;" placeholder="Enter School Graduated " class="form-control input-xs" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="sy">School Year</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" style="width:150px" id="sy" name="sy" type="text" placeholder="FROM-TO" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="tn">Total Number Of Years</label>
                                    <br>
                                    <div class="col-xs-6">
                                        <input id="tn" name="tny" type="number" style="width:100px;text-align:right" class="form-control input-xs" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="ave">General Average</label>
                                    <div class="col-xs-6">
                                        <input id="ave" name="ave" type="number" style="width:100px;text-align:right" class="form-control input-xs" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success " name="submitb" value="Submit Form">
                </form>
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

       <div class="col-md-12">
          
       <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Grade 10</h3>

        </div> 
      
        <div class="panel-body"> 
        <table id="example" class="display" style="width:100%">
        <thead>
            <tr id="heads">
                <th style="width:10%;text-align:center">LRN NO.</th>
                <th style="width:30%;text-align:center">Name</th>
                <th style="width:20%;text-align:center">Gender</th>
                <th style="width:20%;text-align:center">Address</th>
                <th style="width:10%;text-align:center"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db.php';
            $sql = mysqli_query($conn, "SELECT * FROM student_info WHERE PROGRAM = 'grade10' ORDER BY LASTNAME");
            while ($row = mysqli_fetch_assoc($sql)) {
                $sid = $row['STUDENT_ID'];
            ?>
                <tr>
                    <td style="text-align:center"><?php echo $row['LRN_NO'] ?></td>
                    <td style="text-align:center">
                        <?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME'] ?>
                    </td>
                    <td style="text-align:center"><?php echo $row['GENDER'] ?></td>
                    <td style="text-align:center"><?php echo $row['ADDRESS'] ?></td>
                    <td style="text-align:center">
                        <a class="btn btn-info" data-toggle="modal" data-target="#view-modal" data-id="<?php echo $sid ?>" id="getUser">
                            View Profile
                        </a>
                        <!-- <button class="btn btn-danger deleteStudent" data-id="<?php echo $sid ?>">Delete</button> -->
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

<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Profile</h4>
            </div>
            <div class="modal-body">
                <div id="content">
                    <!-- Dynamic content goes here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modal-content {
    border-radius: 8px;
}

.modal-header {
    background-color: #007bff;
    color: white;
}

.modal-title {
    display: flex;
    align-items: center;
}

.modal-body {
    padding: 20px;
}
</style>

<script>
    new DataTable('#example');

    $(document).ready(function () {
        // Handle delete button click
        $(document).on('click', '.deleteStudent', function () {
            const sid = $(this).data('id'); // Get student ID
            if (confirm("Are you sure you want to delete this student?")) {
                $.ajax({
                    url: 'Students_delete.php', // PHP file for handling deletion
                    type: 'POST',
                    data: { id: sid },
                    success: function (response) {
                        if (response.trim() === "success") {
                            alert("Student deleted successfully!");
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert("Error: Unable to delete student.");
                        }
                    },
                    error: function () {
                        alert("An error occurred while processing the request.");
                    },
                });
            }
        });
    });
</script>

