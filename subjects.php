<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
         
      <?php
            include 'newsubject.php';
                ?> 
                <div class="row-md-3" style="display: flex; justify-content: flex-end;">
                  <br>
                  <br>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true" ></i>Add New</button></div>
        </div>
       <div class="col-md-12 " id="s_page">
             
              <div class="panel panel-default">
        <div class="panel-heading">
        <center><h3 class="panel-title">List of Subjects</h3></center> 
        <div class="panel-body">  

  <table id="students" class="table table-hover table-bordered">
    <thead>
      <tr>
      <th style="width:5%">No.</th>
        <th style="width:10%">Subjects</th>
        <th style="width:10%">Applicable For</th>
        <th style="width:10%">Description</th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'db.php';

    
    $sql=  mysqli_query($conn, "SELECT *,`FOR` as para FROM subjects Order by SUBJECT ");
    while($row = mysqli_fetch_assoc($sql)) {

        $count = mysqli_num_rows($sql);
     
    ?>

      <tr>
         <input type="hidden" id="id<?php echo $row["SUBJECT_ID"] ?>" name="id" value="<?php echo $row['SUBJECT_ID'] ?>">
        <td><input id="sub<?php echo $row["SUBJECT_ID"] ?>"  name="subj" type="text" style="border:0px" value="<?php echo $row['SUBJECT'] ?>" readonly></td>
          <td><input id="para<?php echo $row["SUBJECT_ID"] ?>"  name="subj" type="text" style="border:0px" value="<?php echo $row['para'] ?>" readonly></td>
        <td><input id="des<?php echo $row["SUBJECT_ID"] ?>" name="desc" type="text" style="border:0px;width:100%" value="<?php echo $row['DESCRIPTION'] ?>" readonly></td>
        <td><center><a onclick="update_subject(<?php echo $row['SUBJECT_ID'] ?>)" class="btn btn-secondary" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil-square" aria-hidden="true" ></i> Edit</a></center></td>
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

<script>
  function update_subject($i){
    var act,sub,para,desc,i =$i;
      para = $("#para"+i).val();
      $("#id").val($("#id"+i).val());
      $("#sub").val($("#sub"+i).val());
      $("#para").html(para);
      $("#des").val($("#des"+i).val());
      $("#head").html("Update Subject");
      $("#btn_add").html("Update");
  }
</script>

    <div class="modal fade" id="myModal">
    <div class="modal-dialog"> 
               <div class="modal-content modal-lg">
                  <div class="modal-header"> 
      <div class="col-md-4">
      <div class="row main">
        <div class="main-login main-center" id="">
        <h3 id="head">Add New Subject</h3>
          <form class="" method="post">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
              <label for="sub" class="cols-sm-2 control-label">Subject</label>
              <div class="cols-sm-4">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-book fa" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" id="sub" name="sub" id="sub"
                  style="width:200px"  placeholder="Enter Subject" value="<?php if(isset($_POST['sub'])){echo $_POST['sub'];} ?>" required/>
                </div>
                 <p>
            <?php if(isset($errors['sub'])){echo "<div class='erlert'><h5>" .$errors['sub']. "</h5></div>"; } ?>
            </p>
              </div>
            </div>
            <div class="form-group">
              <label for="sub" class="cols-sm-2 control-label">For</label>
              <div class="cols-sm-4">
                <div class="input-group">
                  <select name="f" class="form-control" id="para1">
                  <option id="para"></option>
                  <option>All</option>
                  <?php
                  include 'db.php';
                  $sql = mysqli_query($conn,"SELECT * from program ORDER BY PROGRAM");
                  while($row=mysqli_fetch_assoc($sql)){
                   ?>
                  <option value="<?php echo $row['PROGRAM'] ?>">
                  <?php echo $row['PROGRAM'] ?>
                  </option>
                  <?php } mysqli_close($conn); ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="des" class="cols-sm-2 control-label">Description</label>
              <div class="cols-sm-4">
                <div class="input-group">
                  <textarea type="text" class="form-control" name="des" id="des"  
                  style="width:225px;height:50px" placeholder="Enter Description" value="<?php if(isset($_POST['des'])){echo $_POST['des'];} ?>"/></textarea>
                </div>
             <p>
            <?php if(isset($errors['des'])){echo "<div class='erlert'><h5>" .$errors['des']. "</h5></div>"; } ?>
            </p>
              </div>
            </div>


            <div class="form-group ">
            <button 
    class="btn btn-primary" 
>
    Add
</button>

<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>


         
            </div>
            
          </form>
        </div>
      </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
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
