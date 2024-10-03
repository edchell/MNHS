
          
      <?php
            include 'new_grade.php';
                ?> 
       <div class="col-md-8 " id="s_page">
        
             
              <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">List of Grades</h3>
        </div> 
        <div class="panel-body">  

  <table id="students" class="table table-hover table-bordered">
    <thead>
      <tr>
        <th style="width:20%">Grade</th>
        <th style="width:10%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'boxes.php';

    
    $sql=  mysqli_query($conn, "SELECT * FROM grade Order by grade_id ASC ");
    while($row = mysqli_fetch_assoc($sql)) {

        $count = mysqli_num_rows($sql);
     
    ?>

      <tr>
         <input type="hidden" id="id<?php echo $row["grade_id"] ?>" name="id" value="<?php echo $row['grade_id'] ?>">
        <td><input id="grade<?php echo $row["grade_id"] ?>"  name="" type="text" style="border:0px" value="<?php echo $row['grade'] ?>" readonly></td>
        <td><center><a onclick="update_grade(<?php echo $row["grade_id"]?>)" class="btn btn-secondary" ><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a></center></td>
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
  function update_grade($i){
   var i = $i;
      $("#id").val($("#id"+i).val());
      $("#grade").val($("#grade"+i).val());
      $("#head").html('Update Grade');
      $("#btn_add").html('Update');
     
  
     



  }
</script>


      <div class="col-md-4" id="">
            <div class="container frm-new">
      <div class="row main">
        <div class="main-login main-center">
      <center>  <h3 id="head">Add New Grade</h3> </center>
          <form class="" method="post">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
              <div class="cols-sm-4">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" id="grade" name="grade"
                  style="width:200px" value="<?php if(isset($_POST['grade'])){echo $_POST['grade'];} ?>"/>
                </div>
                 <p>
            <?php if(isset($errors['grade'])){echo "<div class='erlert' id='alert'><h5>" .$errors['grade']. "</h5></div>"; } ?>
            </p>
              </div>
            </div>
            <div id="status"></div>
  

            <div class="form-group ">
            <button 
    class="btn btn-info" 
    id="btn_add"
    style="
        background-color: #28a745; /* Custom green background */
        color: white; /* White text */
        padding: 10px 20px; /* Padding around text */
        font-size: 16px; /* Font size */
        border: none; /* No border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s; /* Smooth background color transition */
    "
>
    Add
</button>

<input 
    type="reset" 
    class="btn btn-info" 
    id="reset" 
    name="reset" 
    value="Cancel"
    style="
        background-color: #dc3545; /* Custom red background */
        color: white; /* White text */
        padding: 10px 20px; /* Padding around text */
        font-size: 16px; /* Font size */
        border: none; /* Remove border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        text-align: center; /* Center text */
        transition: background-color 0.3s; /* Smooth transition on hover */
    "
>

              
            </div>
            
          </form>
        </div>
      </div>

    </div>
    </div>
