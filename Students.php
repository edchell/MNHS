
<style>
        /* Background color for Submit Form button */
        .btn-primary {
            background-color: #5cb85c; /* Green */
            color: #fff; /* Text color */
        }

        /* Background color for Cancel button */
        .btn-primary[data-dismiss="modal"] {
            background-color: #6c757d; /* Grey */
            color: #fff; /* Text color */
        }

        /* Background color for New Entry button */
        .btn-info {
            background-color: #5bc0de; /* Light Blue */
            color: #fff; /* Text color */
        }

        /* Background color for View Profile button */
        .btn-info#getUser {
            background-color: #5bc0de; /* Light Blue */
            color: #fff; /* Text color */
        }

        /* Background color for Close button */
        .btn.btn-close {
            color: #fff; /* Black */
        }

        /* Button hover styles */
        .btn-info.custom-add:hover {
            background-color: #31b0d5 !important; /* Darker blue for hover effect */
            color: #fff !important;
        }

        .btn-info.custom-cancel:hover {
            background-color: #da4646 !important; /* Darker red for hover effect */
            color: #fff !important;
        }
    </style>
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
  include 'newstudent.php';
  ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    /* Background color for Submit Form button */
    .btn-primary {
        background-color: #5cb85c; /* Green */
        color: #fff; /* Text color */
    }

    /* Background color for Cancel button */
    .btn-primary[data-dismiss="modal"] {
        background-color: #6c757d; /* Grey */
        color: #fff; /* Text color */
    }

    /* Background color for New Entry button */
    .btn-info {
        background-color: #5bc0de; /* Light Blue */
        color: #fff; /* Text color */
    }

    /* Background color for View Profile button */
    .btn-info#getUser {
        background-color: #5bc0de; /* Light Blue */
        color: #fff; /* Text color */
    }

    /* Background color for Close button */
    .btn btn-close {
        color: #fff; /* Black */
    }

    /* Button hover styles */
    .btn-info.custom-add:hover {
        background-color: #31b0d5 !important; /* Darker blue for hover effect */
        color: #fff !important;
    }

    .btn-info.custom-cancel:hover {
        background-color: #da4646 !important; /* Darker red for hover effect */
        color: #fff !important;
    }
</style>


<button style="float:right; background-color: #5bc0de;" type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
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
  <label class="col-xs-4 control-label" for="lrn">LRN</label>  
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
      style="text-transform: capitalize;" name="lname" placeholder="Lastname"  type="text" required="">
      <input id="name" class="form-control input-xs"
      style="text-transform: capitalize;" name="fname" placeholder="Firstname"  type="text" required="">
      <input id="name" class="form-control input-xs"
      style="text-transform: capitalize;" name="mname" placeholder="Middlename"  type="text" required="">

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
  <label class="col-xs-5 control-label" for="address">Birth Place</label>
  <div class="col-xs-6">
    <div class="input-group">
      <input id="address" class="form-control input-xs"
      style="text-transform: capitalize;" name="bp" placeholder="Birth Place"  type="text" required="">    </div>
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
<div class="col-md-12">
<br>
<div class="form-group">
  <label class="col-xs-2 control-label" for="icc">Course</label> 
  <br>
  <div class="col-xs-6">
  <input id="icc" name="icc" type="text"
  style="text-transform: capitalize;"
   placeholder="Enter School Graduated " class="form-control input-xs" required="">
  </div>
</div>
  <div class="form-group">
    <label class="col-xs-2 control-label" for="sy">School Year</label>
  <div class="col-xs-10s">
    <input class="form-control" style="width:150px" id="sy" name="sy" type="text"
     placeholder="FROM-TO">

  </div>
  </div>
  

  <div class="form-group">
  <label class="col-xs-2 control-label" for="tn">Years</label> 
  <div class="col-xs-6">
  <input id="tn" name="tny" type="number" style="width:100px;text-align:right"
   class="form-control input-xs" required="">
  </div>
</div>

<div class="form-group">
  <label class="col-xs-2 control-label" for="ave">General Average</label> 
  <div class="">
  <input id="ave" name="ave" type="integer" style="width:100px;text-align:right"
   class="form-control input-xs" required="">

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
        <!--<input type="reset" class="btn btn-primary" id="reset" name="reset" value="Reset Form">-->
      <input type="submit" class="btn btn-primary" name="submitb" value="Submit Form">
      
        </form>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        
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
        <table id="students" class="table table-bordered table-condensed">
            <thead>
                <tr id="heads">
                <th style="width:10%">#.</th>
                <th style="width:10%;text-align:center"> LRN NO.</th>
                    <th style="width:10%;text-align:center">Name</th>
                    <th style="width:30%;text-align:center">Name</th>
                    <th style="width:20%;text-align:center">Curriculum</th>
                
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $sql = mysqli_query($conn, "SELECT * FROM student_info ORDER BY LASTNAME");
                while ($row = mysqli_fetch_assoc($sql)) {
                    $sid = $row['STUDENT_ID'];
                    $sql2 = mysqli_query($conn, "SELECT * FROM program WHERE PROGRAM_ID = '" . $row['PROGRAM'] . "'");
                    while ($row2 = mysqli_fetch_assoc($sql2)) {
                ?>
                <tr>
                <td><?php echo $row['STUDENT_ID'] ?></td>
                    <td><?php echo $row['LRN_NO']; ?></td>
                    <td><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME']; ?></td>
                    <td style="text-align:center"><?php echo $row2['PROGRAM']; ?></td>
                    <td style="text-align:center">
                       <!-- View Profile Button -->
<a class="btn btn-info" data-toggle="modal" data-target="#view-modal" data-id="<?php echo $sid; ?>" id="getUser" style="background-color: #5bc0de;">View Profile</a>

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


       <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog"> 
               <div class="modal-content modal-lg">  
             
                  <div class="modal-header"> 
                     <h4 class="modal-title" style="padding: 10px;">
                     <i class=""></i> PROFILE
                     </h4> 
                  </div> 
                       <div id="content">
                      
                     </div>
                  
                                 
              </div> 
            </div>
          </div>  

           

<script type="text/javascript">
    $(function() {
        $("#students").dataTable(
            { "aaSorting": [[ 2, "asc" ]] }
        );
    });
</script>

   <script type="text/javascript">
$(document).ready(function() {
    // Initialize DataTable if it's not already initialized
    if (!$.fn.DataTable.isDataTable('#students')) {
        $("#students").DataTable({
            "aaSorting": [[2, "asc"]], // Default sorting by the third column (index starts at 0)
            "paging": true,           // Enable pagination
            "searching": true,        // Enable search box
            "ordering": true,         // Enable column sorting
            "info": true              // Display information (e.g., showing 1 to 10 of 50 entries)
        });
    }

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
