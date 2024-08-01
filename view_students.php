<div class="modal-body">
    <?php
    include 'db.php';
    $id = $_POST['id'];

    if ($_POST['id']) {
        $sql = mysqli_query($conn, "SELECT * FROM student_info 
                                    LEFT JOIN program ON student_info.PROGRAM = program.PROGRAM_ID 
                                    WHERE STUDENT_ID = '$id'");
        while ($row = mysqli_fetch_assoc($sql)) {
    ?>
        <input type="hidden" name="id" value="<?php echo $id ?>">

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>LRN:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['LRN_NO'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Name:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['LASTNAME'] . ", " . $row['FIRSTNAME'] . " " . $row['MIDDLENAME']; ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Gender:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['GENDER'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Date of Birth:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['DATE_OF_BIRTH'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Place of Birth:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['BIRTH_PLACE'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Address:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['ADDRESS'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Parent or Guardian:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['PARENT_GUARDIAN'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Parent or Guardian Address:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['P_ADDRESS'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Intermediate Course Completed:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['INT_COURSE_COMP'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Total No. of Years:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['TOTAL_NO_OF_YEARS'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>School Year:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['SCHOOL_YEAR'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>General Average:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['GEN_AVE'] ?>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <div class="row">
                <div class="col-md-5 text-right">
                    <label>Curriculum Enrolled:</label>
                </div>
                <div class="col-md-7 text-left">
                    <?php echo $row['PROGRAM'] ?>
                </div>
            </div>
        </div>

    <?php
        }
    }
    mysqli_close($conn);
    ?>
</div>

<div class="modal-footer">
    <a class="btn btn-primary" href="rms.php?page=student_p&id=<?php echo $id ?>">Update</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
