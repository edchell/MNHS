<?php
include('auth.php');
?>
<h3 class="page-header">Grade <small>section</small></h3>
<?php
include 'new_grade.php';
?>
<div class="col-md-8" id="s_page">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">List of Grades</h3>
    </div>
    <div class="panel-body">
      <table id="example" class="display" style="width:100%">
        <thead>
          <tr>
            <th style="width:10%; text-align:center">Grade</th>
            <th style="width:10%; text-align:center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';

          $sql = mysqli_query($conn, "SELECT * FROM grade ORDER BY grade_id ASC");
          while ($row = mysqli_fetch_assoc($sql)) {
          ?>
            <tr>
              <td id="grade<?php echo $row['grade_id']; ?>" style="text-align:center"><?php echo htmlspecialchars($row['grade']); ?></td>
              <td>
                <center>
                  <button onclick="update_grade(<?php echo $row['grade_id']; ?>)" class="btn btn-info">
                    <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit
                  </button>
                </center>
              </td>
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
  function update_grade(id) {
    // Retrieve grade value
    const gradeValue = document.getElementById(`grade${id}`).textContent.trim();

    // Populate the form with retrieved data
    document.getElementById('id').value = id;
    document.getElementById('grade').value = gradeValue;

    // Update form heading and button text
    document.getElementById('head').textContent = 'Update Grade';
    document.getElementById('btn_add').textContent = 'Update';
  }

  // Initialize DataTable
  new DataTable('#example');
</script>

<div class="col-md-4">
  <div class="container frm-new">
    <div class="row main">
      <div class="main-login main-center">
        <h3 id="head">Add New Grade</h3>
        <form method="post">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="grade" class="cols-sm-2 control-label">Grade</label>
            <div class="cols-sm-4">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="grade" name="grade" style="width:200px" 
                       placeholder="Enter grade" value="<?php echo isset($_POST['grade']) ? htmlspecialchars($_POST['grade']) : ''; ?>" />
              </div>
              <p>
                <?php if (isset($errors['grade'])) echo "<div class='erlert' id='alert'><h5>{$errors['grade']}</h5></div>"; ?>
              </p>
            </div>
          </div>
          <div id="status"></div>
          <div class="form-group">
            <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel">
            <button class="btn btn-info" id="btn_add">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
