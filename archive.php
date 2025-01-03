<?php
include('auth.php');
?>
<?php
include 'newstudent.php';
?>

<h1 class="page-header">ARCHIVED</h1>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Archived List</h3>
        </div> 
        <div class="panel-body"> 
        <table id="example" class="display" style="width:100%">
    <thead>
      <tr id="heads">
        <th style="width:20%">Name</th>
        <th style="width:10%">User</th>
        <th style="width:10%">Type</th>
        <th style="width:10%">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    include 'db.php';
    $sql=  mysqli_query($conn, "SELECT * FROM user WHERE STATUS = 'archived'");
    while($row = mysqli_fetch_assoc($sql)) {
    ?>
      <tr>

      <td><?php echo htmlspecialchars($row['FIRSTNAME'] . " " . $row['LASTNAME']); ?></td>
      <td><?php echo htmlspecialchars($row['USER']); ?></td>
      <td><?php echo htmlspecialchars($row['USER_TYPE']); ?></td>
      <td>
            <a href="#" class="restoreUser btn btn-primary" data-id="<?php echo $row['USER_ID']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Restore">
                <i class="fa fa-repeat" aria-hidden="true"></i>
            </a>
            <button class="deleteUser btn btn-danger" data-id="<?php echo $row['USER_ID']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

<script type="text/javascript">
        new DataTable('#example');

        $(document).on('click', '.restoreUser', function() {
        const userId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to restore this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('user_restore.php', { id: userId }, function(response) {
                    Swal.fire(
                        'Restored!',
                        response,
                        'success'
                    ).then(() => {
                        location.reload(); // Refresh the page to see the changes
                    });
                });
            }
        });
    });
    </script>

<script type="text/javascript">
    $(document).on('click', '.deleteUser', function() {
        const userId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('archived_delete.php', { id: userId }, function(response) {
                    Swal.fire(
                        'Deleted!',
                        response,
                        'success'
                    ).then(() => {
                        location.reload(); // Refresh the page to see the changes
                    });
                });
            }
        });
    });
</script>

