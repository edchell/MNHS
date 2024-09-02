<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


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
    $sql=  mysqli_query($conn, "SELECT * FROM user WHERE STATUS = 'Archived' ORDER BY STATUS");
    while($row = mysqli_fetch_assoc($sql)) {
      $sid = $row['USER_ID'];
      $sql2=  mysqli_query($conn, "SELECT * FROM program WHERE PROGRAM_ID = '".$row['PROGRAM']."' ");
         while($row2 = mysqli_fetch_assoc($sql2)) {    


    ?>
      <tr>

        <td><?php echo $row['USER_ID'] ?></td>
        <td><?php echo $row['FIRSTNAME']." ".$row['LASTNAME'] ?></td>
        <td><?php echo $row['USER'] ?></td>
        <td><?php echo $row['USER_TYPE'] ?></td>
        
     
      <td style="text-align:center"> 
      <a  style="
        background-color: #007bff; /* Custom blue background */
        color: white; /* White text */
        padding: 10px 20px; /* Padding around text */
        font-size: 16px; /* Font size */
        border: none; /* Remove border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s; /* Smooth transition on hover */
    "  class="btn btn-default" data-toggle="modal" data-target="#view-modal" data-id="<?php echo $sid ?>" id="getUser">Unarchived</a>


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
                  <button 
    type="button" 
    class="close" 
    data-dismiss="modal" 
    style="
        background-color: #dc3545; /* Custom background color */
        color: white;              /* Text color */
        border: none;              /* Remove border */
        font-size: 24px;           /* Font size */
        border-radius: 50%;        /* Round button */
        padding: 10px;             /* Padding around the content */
        opacity: 0.8;              /* Slightly transparent */
    "
>
    &times;
</button>


                     <h4 class="modal-title">
                     <i class=""></i> PROFILE
                     </h4> 
                  </div> 
                       <div id="content">
                      
                     </div>
                  
                                 
              </div> 
            </div>
          </div>  



          <script type="text/javascript">
$(document).ready(function() {
    // Define custom sorting for grades
    $.fn.dataTable.ext.order['grade-order'] = function(settings, column, order) {
        var data = this.api().column(column, {order: 'index'}).data();
        var orderMap = {
            'grade7': 1,
            'grade8': 2,
            'grade9': 3,
            'grade10': 4,
            'grade11': 5,
            'grade12': 6
        };
        return data.map(function(value) {
            return orderMap[value] || 0; // Default to 0 if not found
        });
    };

    // Initialize DataTable
    $("#students").DataTable({
        "aaSorting": [[4, "asc"]], // Default sorting by the 12th column (index starts at 0)
        "paging": true,           // Enable pagination
        "searching": true,        // Enable search box
        "ordering": true,         // Enable column sorting
        "info": true,             // Display information (e.g., showing 1 to 10 of 50 entries)
        "columnDefs": [
            { "orderDataType": "grade-order", "targets": 4 } // Apply custom sorting to the 12th column
        ]
    });
});
</script>

       <script type="text/javascript">
$(document).ready(function() {
    // Initialize DataTable if it's not already initialized
    if (!$.fn.DataTable.isDataTable('#students')) {
        $("#students").DataTable({
            "aaSorting": [[4,"asc"]], // Default sorting by the third column (index starts at 0)
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