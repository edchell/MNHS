<?php
include('auth.php');
?>
<h1 class="page-header">School Year</h1>
<?php
include 'new_school_year.php';
?>
<div class="col-md-8" id="s_page">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">List of School Year</h3>
    </div>
    <div class="panel-body">
      <table id="example" class="display" style="width:100%">
        <thead>
          <tr>
            <th style="width:20%">School Year</th>
            <th style="width:10%">Current</th>
            <th style="width:10%"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';

          $sql = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year DESC");
          while ($row = mysqli_fetch_assoc($sql)) {
          ?>
            <tr>
              <td id="sy<?php echo $row['SY_ID']; ?>"><?php echo htmlspecialchars($row['school_year']); ?></td>
              <td id="stats<?php echo $row['SY_ID']; ?>"><?php echo htmlspecialchars($row['status']); ?></td>
              <td>
                <center>
                  <button onclick="update_sy(<?php echo $row['SY_ID']; ?>)" class="btn btn-info">
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
  function update_sy(id) {
    // Retrieve the school year and status values
    const schoolYear = document.getElementById(`sy${id}`).textContent.trim();
    const status = document.getElementById(`stats${id}`).textContent.trim();

    // Populate the form with retrieved data
    document.getElementById('id').value = id;
    document.getElementById('sy').value = schoolYear;

    // Change the form heading and button text to "Update"
    document.getElementById('head').textContent = 'Update School Year';
    document.getElementById('btn_add').textContent = 'Update';

    // Generate the status dropdown dynamically
    const statusHTML = `
      <div class="form-group">
        <label for="status" class="cols-sm-2 control-label">Current</label>
        <div class="cols-sm-4">
          <select name="status" class="form-control">
            <option value="${status}">${status}</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
      </div>
    `;
    document.getElementById('status').innerHTML = statusHTML;
  }
</script>

<div class="col-md-4">
  <div class="container frm-new">
    <div class="row main">
      <div class="main-login main-center">
        <h3 id="head">Add New School Year</h3>
        <form method="post">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="sy" class="cols-sm-2 control-label">School Year</label>
            <div class="cols-sm-4">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="sy" name="sy" style="width:200px" placeholder="(From - To)" value="<?php echo isset($_POST['sy']) ? htmlspecialchars($_POST['sy']) : ''; ?>"/>
              </div>
              <p>
                <?php if (isset($errors['sy'])) echo "<div class='erlert' id='alert'><h5>{$errors['sy']}</h5></div>"; ?>
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

<script>
  // Initialize DataTable for the table
  new DataTable('#example');
</script>
