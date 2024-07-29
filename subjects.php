

      <?php
            include 'newsubject.php';
                ?> 
       <div class="col-md-8 " id="s_page">
        
       <style>
    /* Background color for Add button */
    .btn-info.custom-add {
        background-color: #5bc0de !important; /* Light Blue */
        color: #fff !important; /* Text color */
    }

    /* Background color for Cancel button */
    .btn-info.custom-cancel {
        background-color: #da4646 !important; /* Red */
        color: #fff !important; /* Text color */
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
  

              <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">List of Subjects</h3>
        </div> 
        <div class="panel-body">  

  <table id="students" class="table table-hover table-bordered">
    <thead>
      <tr>
      <tr id="heads">
      
        <th style="width:20%">Subjects</th>
        <th style="width:10%">Applicable For</th>
        <th style="width:10%">Description</th>
        <th style="width:10%"></th>
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
        <td><center><a onclick="update_subject(<?php echo $row["SUBJECT_ID"] ?>)" class="btn btn-info" ><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</a></center></td>
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
    function resetForm() {
        document.getElementById("subjectForm").reset();
        $("#head").html("Add New Subject");
        $("#btn_add").html("Add");
        $("#id").val(''); // Clear hidden input value
        $("#sub").val(''); // Clear subject input value
        $("#para1").val(''); // Clear select box value for 'For'
        $("#des").val(''); // Clear description textarea value

        // Hide the modal after resetting
        $('#myModal').modal('hide');
    }
</script>





      <div class="col-md-4" id="">
   
        <div class="modal-header">
            <div class="main-login main-center">
               <center> <h3 id="head">Add New Subject</h3> </center>
            
                <form class="" method="post">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book fa" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" id="sub" name="sub" style="width:200px" placeholder="Enter Subject" value="<?php if(isset($_POST['sub'])){echo $_POST['sub'];} ?>"/>
                            </div>
                            <p>
                                <?php if(isset($errors['sub'])){echo "<div class='erlert'><h5>" .$errors['sub']. "</h5></div>"; } ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <select name="f" class="form-control" id="para1">
                                    <option id="para"></option>
                                    <?php
                                    include 'db.php';
                                    $sql = mysqli_query($conn, "SELECT * from program ORDER BY PROGRAM");
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
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <textarea type="text" class="form-control" name="des" id="des" style="width:225px;height:50px" placeholder="Enter Description"><?php if(isset($_POST['des'])){echo $_POST['des'];} ?></textarea>
                            </div>
                            <p>
                                <?php if(isset($errors['des'])){echo "<div class='erlert'><h5>" .$errors['des']. "</h5></div>"; } ?>
                            </p>
                        </div>
                    </div>

                    
                    <div class="form-group">
    <button class="btn btn-info custom-add" id="btn_add">Add</button>
   

</div>

                        
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function update_subject(subject_id) {
        var subject_id = subject_id;
        var subject = $("#sub" + subject_id).val();
        var para = $("#para" + subject_id).val();
        var description = $("#des" + subject_id).val();

        $("#id").val(subject_id);
        $("#sub").val(subject);
        $("#para1").val(para); // Update the select box value for 'For'
        $("#des").val(description);
        $("#head").html("Update Subject");
        $("#btn_add").html("Update");

        // Show the modal if it's not already visible
        $('#myModal').modal('show');
    }
</script>

           
 <script type="text/javascript">
        $(function() {
            $("#students").dataTable(
        { "aaSorting": [[ 0, "asc" ]] }
      );
        });
    </script>
