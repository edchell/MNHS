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
            <a href="#" class="text-primary restoreUser" data-id="<?php echo $row['USER_ID']; ?>">
                <i class="fa fa-repeat" aria-hidden="true"></i> Restore
            </a>
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
        if (confirm("Are you sure you want to restore this user?")) {
            $.post('user_restore.php', { id: userId }, function(response) {
                alert(response);
                location.reload(); // Refresh the page to see the changes
            });
        }
    });
    </script>
