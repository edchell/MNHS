<?php
include('auth.php');
?>


          <h1 class="page-header">Search Student Records</h1>

          <div class="container">
        <div class="input-group">
    </div>
    </div>

       <div class="col-md-12"> 
       <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Students List</h3>
        </div> 
        <div class="panel-body">  
        <table id="example" class="display" style="width:100%">
    <thead>
      <tr id="heads">
        <th style="width:10%">LRN NO.</th>
        <th style="width:20%">Name</th>
        <th style="width:5%">Gender</th>
        <th style="width:5%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'db.php';
    $sql=  mysqli_query($conn, "SELECT * FROM student_info ");
    while($row = mysqli_fetch_assoc($sql)) {

    ?>
      <tr>

        <td><?php echo $row['LRN_NO'] ?></td>
        <td><?php echo $row['LASTNAME'] . ' ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></td>
        <td><?php echo $row['GENDER'] ?></td>
        <td>
    <center><a class="btn btn-info" onclick='window.open("form137.php?id=<?php echo $row['STUDENT_ID']; ?>")'>
        <i class="fa fa-fw fa-print"></i>Printable Report
    </a></center>
</td>
      </tr>
      <?php
    } mysqli_close($conn);
      ?>
      
    </tbody>
  </table>
</div>
</div>
</div>


          </div>

    </div>


     <script>
        new DataTable('#example');
    </script>

