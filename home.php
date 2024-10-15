<?php
include('auth.php');
?>
<style>
    .page-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .card-container {
        display: flex;
        justify-content: space-around;
    }

    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        width: 30%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .card h2 {
        margin-top: 0;
    }

    .card p {
        color: #555;
    }
</style>

<h1 class="page-header">
    <b>Madridejos National High School</b>
    <br>
    <small>Student Grading System</small>
</h1>
<div class="card-container">
    <div class="card">
        <?php
        include 'db.php';

        // Fetch all students
        $sql = mysqli_query($conn, "SELECT * FROM student_info");
        $total_students = mysqli_num_rows($sql);
        
        // Initialize counters
        $total_male = 0;
        $total_female = 0;

        // Count male and female students
        while ($row = mysqli_fetch_assoc($sql)) {
            if ($row['GENDER'] == 'MALE') {
                $total_male++;
            } elseif ($row['GENDER'] == 'FEMALE') {
                $total_female++;
            }
        }
        mysqli_close($conn);
        ?>
        <h2><?php echo $total_students; ?></h2>
        <p>Total Students</p>
    </div>
    <div class="card">
        <h2><?php echo $total_male; ?></h2>
        <p>Total Male Students</p>
    </div>
    <div class="card">
        <h2><?php echo $total_female; ?></h2>
        <p>Total Female Students</p>
    </div>
</div>
<br>
<div class="card-container">
    <div class="card">
        <?php
        include 'db.php';
        
        // Fetch total users
        $sql = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM user");
        $row = mysqli_fetch_assoc($sql);
        $total_users = $row['total_users'];
        mysqli_close($conn);
        ?>
        <h2><?php echo $total_users; ?></h2>
        <p>Total Users</p>
    </div>
    <div class="card">
        <?php
        include 'db.php';
        
        // Fetch total subjects
        $sql = mysqli_query($conn, "SELECT COUNT(*) as total_subjects FROM subjects");
        $row = mysqli_fetch_assoc($sql);
        $total_subjects = $row['total_subjects'];
        mysqli_close($conn);
        ?>
        <h2><?php echo $total_subjects; ?></h2>
        <p>Total Subjects</p>
    </div>
</div>
