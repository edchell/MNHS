<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student Records</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Bootstrap CSS (optional) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="page-header">Search Student Records</h1>

        <!-- Search Bar -->
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group">
                    <input type="text" class="form-control" id="search" placeholder="Search for students...">
                </div>
            </div>
        </div>


          

          <div class="container">
            <div class="col-sm-3">
        <div class="input-group">
    </div>
    </div>

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
    include 'db.php';
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
    <a 
        class="btn btn-info" 
        onclick='window.open("form137.php?id=<?php echo $row['STUDENT_ID'] ?>")'
        style="background-color: #17a2b8; border-color: #17a2b8; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;"
    >
        <i class="fa fa-fw fa-print"></i> Printable Report
    </a>
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
            var table = $("#students").DataTable({
                "aaSorting": [[ 0, "asc" ]]
            });

            // Search functionality
            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
