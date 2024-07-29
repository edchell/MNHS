
<!-- Add this CSS to your stylesheet or inline -->
<style>
    .modal-dialog {
        max-width: 50%; /* Adjust the percentage as needed */
        margin: 1.75rem auto; /* Center the modal vertically */
    }
    /* Modal Content */
    .modal-content {
    display: flex;
    padding: 2%;
    flex-wrap: wrap;
    align-items: stretch;
    height: 50vh;
    align-content: stretch;
    justify-content: space-evenly;
}
/* Content */
.modal-body .text-start {
    font-size: 1.75rem; /* Increase font size for content text */
    padding: 6px;
}
/* Labels */
.modal-body label {
    font-size: 1.4rem; /* Increase font size for labels */
}
</style>

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
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
        
        <div class="container">
            <!-- LRN -->
            <div class="row mb-3">  
                <div class="col-md-5 text-end">
                    <label>LRN:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['LRN_NO'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Name -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Name:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['LASTNAME'], ENT_QUOTES, 'UTF-8') . ", " . htmlspecialchars($row['FIRSTNAME'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['MIDDLENAME'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Gender -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Gender:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['GENDER'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Date of Birth -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Date of Birth:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['DATE_OF_BIRTH'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Place of Birth -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Place of Birth:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['BIRTH_PLACE'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Address -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Address:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['ADDRESS'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Parent or Guardian -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Parent or Guardian:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['PARENT_GUARDIAN'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Parent or Guardian Address -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Parent or Guardian Address:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['P_ADDRESS'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Intermediate Course Completed -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Intermediate Course Completed:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['INT_COURSE_COMP'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Total no. of years -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Total no. of years:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['TOTAL_NO_OF_YEARS'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- School Year -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>School Year:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['SCHOOL_YEAR'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- General Average -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>General Average:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['GEN_AVE'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Curriculum Enrolled -->
            <div class="row mb-3">
                <div class="col-md-5 text-end">
                    <label>Curriculum Enrolled:</label>
                </div>
                <div class="col-md-7 text-start">
                    <?php echo htmlspecialchars($row['PROGRAM'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <!-- Buttons -->
            <div class="row">
                <div class="col-md-12 text-right">
                    <a class="btn btn-primary" href="rms.php?page=student_p&id=<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">Update</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    <?php
        }
    }
    mysqli_close($conn);
    ?>

</div>
