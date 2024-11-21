<?php
include('auth.php');
?>

 <?php
    include 'db.php';
    if($_POST['id']){
      $id = $_POST['id'];
    $sql=  mysqli_query($conn, "SELECT * FROM user where USER_ID = '$id'");
    while($row = mysqli_fetch_assoc($sql)) {


    ?>
       <div class="form-group">
        <label class="control-label col-sm-2" for="fname">Firstname:</label>
      <div class="col-sm-5">  
              <input type="hidden" class="form-control" name="id" value="<?php echo $row['USER_ID'] ?>" >
        
          <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['FIRSTNAME'] ?>" >
      </div>
    </div> 
    <br>
    <br>
    <div class="form-group">
      <label class="control-label col-sm-2" for="lname">Lastname:</label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row['LASTNAME'] ?>" >
      </div>
    </div>
    <br>
    <div class="form-group">
      <label class="control-label col-sm-2" for="phone">Phone No.:</label>
      <div class="col-sm-5">          
        <input type="text" maxlength="11" class="form-control" id="phone" name="phone" value="<?php echo $row['PHONE'] ?>" >
      </div>
    </div>
    <br>
    <br>

    <div class="form-group">
      <label class="control-label col-sm-2" for="user">User:</label>
      <div class="col-sm-5">          
        <input type="text" class="form-control" id="user" name="user" value="<?php echo $row['USER'] ?>" >
      </div>
    </div>
    <br>    
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">User Type:</label>
      <div class="col-sm-5">   
        <select class="form-control" name="type" id="sel1">
        <option><?php echo $row['USER_TYPE']?></option>
        <?php
        if($row['USER_TYPE'] == "STAFF"){ ?>
          <option value="ADMINISTRATOR">ADMINISTRATOR</option>
        <?php }else{?>
          <option value="FACULTY TEACHER">FACULTY TEACHER</option>
        <?php } ?>
        </select>
      </div>
    </div>
    <br>
    <br>
   


<?php } }
mysqli_close($conn); ?>