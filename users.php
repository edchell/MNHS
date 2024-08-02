
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){

    $(document).on('click', '#getUser', function(e){
  
     e.preventDefault();
  
     var uid = $(this).data('id');      
 
     $.ajax({
          url: 'view_user.php',
          type: 'POST',
          data: 'id='+uid,
          beforeSend:function()
{
 $("#e_user").html('Working on Please wait ..');
},
success:function(data)
{
   $("#e_user").html(data);
},
     })

    });
})
  </script>
     <?php include 'newaccount.php' ?>
       <div class="col-md-8">   
              <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">List of Users</h3>
        </div> 
        <div class="panel-body">  

  <table id="students" class="table table-hover table-bordered">
    <thead>
      <tr id="heads">
      <th style="width:20%">No.</th>
        <th style="width:20%">Name</th>
        <th style="width:10%">User</th>
        <th style="width:10%">Type</th>
        <th style="width:30%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'db.php';
    $sql=  mysqli_query($conn, "SELECT * FROM user ");
    while($row = mysqli_fetch_assoc($sql)) {


    ?>
    <form method="post" action="update_subject.php">
      <tr>
      <td><?php echo $row['USER_ID'] ?></td>
        <td><?php echo $row['FIRSTNAME']." ".$row['LASTNAME'] ?></td>
        <td><?php echo $row['USER'] ?></td>
        <td><?php echo $row['USER_TYPE'] ?></td>
        <td><a class="btn btn-primary" data-toggle="modal" data-target="#edit_user" data-id="<?php echo $row['USER_ID'] ?>" id="getUser"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
        <a class="btn btn-danger" data-id="<?php echo $row['USER_ID'] ?>" id="getUser" onclick="deleteUser(<?php echo $row['USER_ID'] ?>)"><i class="icon-copy fa fa-times-rectangle" aria-hidden="true"></i></a></td>
      </tr>
      </form>
      <?php
    } mysqli_close($conn);
      ?>
      
    </tbody>
  </table>
</div>
</div>
</div>


      <div class="col-md-4">
        
            <div class="container frm-new">
      <div class="row main">
        <div class="main-login main-center">
        <h3>Add New Users</h3>
          <form class="" method="post">
            
            <div class="form-group">
              <div class="cols-sm-4">
                <div class="input-group">
        <input type="text" class="form-control" style="text-transform: capitalize;" id="fname" name="fname" placeholder="Enter Firstname" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="cols-sm-4">
                <div class="input-group">
        <input type="text" class="form-control" style="text-transform: capitalize;" id="fname" name="lname" placeholder="Enter Firstname" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="cols-sm-4">
                <div class="input-group">
        <input type="text" class="form-control" id="fname" name="user" placeholder="Enter Firstname" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="cols-sm-4">
                <div class="input-group">
        <input type="password" class="form-control"" id="fname" name="pwd" placeholder="Enter Firstname" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="cols-sm-4">
                <div class="input-group">
        <select class="form-control" name="type" id="sel1" required>
        <option></option>
          <option value="ADMINISTRATOR">ADMINISTRATOR</option>
          <option value="STAFF">STAFF</option>n>
        </select>                </div>
              </div>
            </div>
            



            <div class="form-group ">
            <button 
    class="btn btn-primary" 
    style="background-color: #28a745; border-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;"
>
    Add
</button>

           <input 
    type="reset" 
    class="btn btn-info" 
    id="reset" 
    name="reset" 
    value="Cancel">
    

             
            </div>
            
          </form>
        </div>
      </div>

    </div>

    <div class="modal fade" id="edit_user" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Acount</h4>
        </div>
        <div class="modal-body"> 
                  <form class="form-group" method="POST" action="edit_user.php"> 
                      <div class="container">                 
                     <div id="e_user">
                      
                      </div>
                     </div>
                  </div> 
                                  
                  <div class="modal-footer">
                   
                  <button type="submit" class="btn btn-default">Save</button>
                  </form>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                  </div> 
    </div>
        </div>
        </div>
      
 <script type="text/javascript">
function deleteUser(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "your_script.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Define what happens on successful data submission
            xhr.onload = function () {
                if (xhr.status === 200) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then(() => {
                        // Optionally, you can refresh the page or remove the user row from the table
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the user.',
                        'error'
                    );
                }
            };

            // Define what happens in case of error
            xhr.onerror = function () {
                Swal.fire(
                    'Error!',
                    'Request failed.',
                    'error'
                );
            };

            // Set up our request
            xhr.send("action=delete&user_id=" + userId);
        }
    });
}

</script>