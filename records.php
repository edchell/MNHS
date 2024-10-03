
          <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
       <div class="col-md-12">   
       <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Students List</h3>
        </div> 
        <div class="panel-body">  
  <table id="students" class="table table-bordered">
    <thead>
      <tr id="heads">
        <th style="width:10%">LRN NO.</th>
        <th style="width:20%">Name</th>
        <th style="width:10%">Gender</th>
        <th style="width:10%">Curriculum</th>
        <th style="width:10%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'boxes.php';
    $sql=  mysqli_query($conn, "SELECT * FROM student_info ");
    while($row = mysqli_fetch_assoc($sql)) {
       $sql2=  mysqli_query($conn, "SELECT * FROM program WHERE PROGRAM_ID = '".$row['PROGRAM']."' ");
         while($row2 = mysqli_fetch_assoc($sql2)) {


    ?>
      <tr>

        <td><?php echo $row['LRN_NO'] ?></td>
        <td><?php echo $row['LASTNAME'] . ' ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></td>
        <td><?php echo $row['GENDER'] ?></td>
        <td><?php echo $row2['PROGRAM'] ?></td>
        <td>
    <center>
        <a 
            class="btn btn-info" 
            href="rms.php?page=record&id=<?php echo $row['STUDENT_ID'] ?>&prog=<?php echo $row2['PROGRAM']?>"
            style="background-color: #007bff; border-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;"
        >
            View Records
        </a>
    </center>
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
 <script type="text/javascript">
        $(function() {
            $("#students").dataTable(
        { "aaSorting": [[ 0, "asc" ]] }
      );
        });
    </script>
     <script type="text/javascript">
$(document).ready(function() {
    // Initialize DataTable if it's not already initialized
    if (!$.fn.DataTable.isDataTable('#students')) {
        $("#students").DataTable({
            "aaSorting": [[0, "asc"]], // Default sorting by the sixth column (index starts at 0)
            "paging": true,           // Enable pagination
            "searching": true,        // Enable search box
            "ordering": true,         // Enable column sorting
            "info": true              // Display information (e.g., showing 1 to 10 of 50 entries)
        });
    }
        });
    </script>


