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
                                    <button onclick="delete_grade(<?php echo $row['grade_id']; ?>)" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
        const gradeValue = document.getElementById(`grade${id}`).textContent.trim();

        document.getElementById('id').value = id;
        document.getElementById('grade').value = gradeValue;

        document.getElementById('head').textContent = 'Update Grade';
        document.getElementById('btn_add').textContent = 'Update';
    }

    function delete_grade(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will permanently delete the grade!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_grade.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response === 'success') {
                            Swal.fire('Deleted!', 'The grade has been deleted.', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            Swal.fire('Error!', 'There was an issue deleting the grade.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'An unexpected error occurred.', 'error');
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        new DataTable('#example');
    });
</script>

<div class="col-md-4">
    <div class="container frm-new">
        <div class="row main">
            <div class="main-login main-center">
                <h3 id="head">Add New Grade</h3>
                <form id="gradeForm" method="post">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="grade" class="cols-sm-2 control-label">Grade</label>
                        <div class="cols-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" id="grade" name="grade" style="width:200px"
                                    placeholder="Enter grade" value="<?php echo isset($_POST['grade']) ? htmlspecialchars($_POST['grade']) : ''; ?>" />
                            </div>
                            <p id="gradeError" style="color: red;"></p>
                        </div>
                    </div>
                    <div id="status"></div>
                    <div class="form-group">
                        <input type="reset" class="btn btn-info" id="reset" name="reset" value="Cancel">
                        <button type="button" class="btn btn-info" id="btn_add" onclick="addOrUpdateGrade()">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
     function addOrUpdateGrade() {
        const id = document.getElementById('id').value;
        const grade = document.getElementById('grade').value.trim();
        const gradeError = document.getElementById('gradeError');

        // Basic validation
        if (grade === '') {
            gradeError.textContent = '* Grade is required.';
            return;
        } else {
            gradeError.textContent = '';
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('grade', grade);

        $.ajax({
            url: 'new_grade.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response === 'success') {
                    Swal.fire('Success!', 'Grade has been ' + (id ? 'updated' : 'added') + '.', 'success')
                        .then(() => {
                            location.reload();
                        });
                } else {
                    Swal.fire('Error!', 'An issue occurred while saving the grade.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'An unexpected error occurred.', 'error');
            }
        });
    }
</script>
