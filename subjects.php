<?php
include('auth.php');
?>
<h1 class="page-header">SUBJECTS</h1>
<?php
include 'newsubject.php';
?> 
<div class="col-md-8" id="s_page">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">List of Subjects</h3>
    </div>
    <div class="panel-body">  
      <table id="example" class="display" style="width:100%">
        <thead>
          <tr>
            <th style="width:10%">ID</th>
            <th style="width:20%">Subjects</th>
            <th style="width:10%">Description</th>
            <th style="width:10%"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db.php';

          $sql = mysqli_query($conn, "SELECT * FROM subjects ORDER BY SUBJECT");
          while ($row = mysqli_fetch_assoc($sql)) {
          ?>
            <tr>
              <td style="text-align:center;"><?php echo htmlspecialchars($row['SUBJECT_ID']); ?></td>
              <td data-id="<?php echo $row['SUBJECT_ID']; ?>" id="sub<?php echo $row['SUBJECT_ID']; ?>"><?php echo htmlspecialchars($row['SUBJECT']); ?></td>
              <td id="des<?php echo $row['SUBJECT_ID']; ?>"><?php echo htmlspecialchars($row['DESCRIPTION']); ?></td>
              <td>
                <center>
                  <button onclick="update_subject(<?php echo $row['SUBJECT_ID']; ?>)" class="btn btn-info">
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
  function update_subject(id) {
    // Get subject and description based on row ID
    const subject = document.getElementById(`sub${id}`).textContent.trim();
    const description = document.getElementById(`des${id}`).textContent.trim();

    // Populate the form fields
    document.getElementById('id').value = id;
    document.getElementById('sub').value = subject;
    document.getElementById('des').value = description;

    // Update the header and button text
    document.getElementById('head').textContent = "Update Subject";
    document.getElementById('btn_add').textContent = "Update";
  }
</script>

<div class="col-md-4">
  <div class="container frm-new">
    <div class="row main">
      <div class="main-login main-center">
        <h3 id="head">Add New Subject</h3>
        <form method="post">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="sub" class="cols-sm-2 control-label">Subject</label>
            <div class="cols-sm-4">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-book fa" aria-hidden="true"></i></span>
                <input type="text" class="form-control" id="sub" name="sub" style="width:200px" placeholder="Enter Subject" value="<?php echo isset($_POST['sub']) ? htmlspecialchars($_POST['sub']) : ''; ?>"/>
              </div>
              <p>
                <?php if (isset($errors['sub'])) echo "<div class='erlert'><h5>{$errors['sub']}</h5></div>"; ?>
              </p>
            </div>
          </div>

          <div class="form-group">
            <label for="des" class="cols-sm-2 control-label">Description</label>
            <div class="cols-sm-4">
              <div class="input-group">
                <textarea class="form-control" name="des" id="des" style="width:225px;height:50px" placeholder="Enter Description"><?php echo isset($_POST['des']) ? htmlspecialchars($_POST['des']) : ''; ?></textarea>
              </div>
              <p>
                <?php if (isset($errors['des'])) echo "<div class='erlert'><h5>{$errors['des']}</h5></div>"; ?>
              </p>
            </div>
          </div>

          <div class="form-group">
            <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel">
            <button class="btn btn-info" id="btn_add">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  new DataTable('#example');
</script>
