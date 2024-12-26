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

    #chart-container {
        width: 50%;
        margin: 30px auto;
    }
</style>

<h1 class="page-header">
    <b>Madridejos National High School</b>
    <br>
    <small>Student Grading System</small>
</h1>
<div class="card-container">
    <div class="card" style="background-color:#91ef91;">
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
        <p style="color: black;">Total Students</p>
    </div>
    <div class="card" style="background-color: #1883cb;">
        <h2><?php echo $total_male; ?></h2>
        <p style="color: black;">Total Male Students</p>
    </div>
    <div class="card" style="background-color: #fad5e6;">
        <h2><?php echo $total_female; ?></h2>
        <p style="color: black;">Total Female Students</p>
    </div>
</div>
<br>
<div class="card-container">
    <div class="card" style="background-color:#dfbbfe;">
        <?php
        include 'db.php';
        
        // Fetch total users
        $sql = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM user WHERE STATUS = ''");
        $row = mysqli_fetch_assoc($sql);
        $total_users = $row['total_users'];
        mysqli_close($conn);
        ?>
        <h2><?php echo $total_users; ?></h2>
        <p style="color: black;">Total Users</p>
    </div>
    <div class="card" style="background-color:#f4f04f;">
        <?php
        include 'db.php';
        
        // Fetch total subjects
        $sql = mysqli_query($conn, "SELECT COUNT(*) as total_subjects FROM subjects");
        $row = mysqli_fetch_assoc($sql);
        $total_subjects = $row['total_subjects'];
        mysqli_close($conn);
        ?>
        <h2><?php echo $total_subjects; ?></h2>
        <p style="color: black;">Total Subjects</p>
    </div>
    <div class="card" style="background-color:#ffd54f;">
        <?php
        include 'db.php';
        
        // Fetch total user archived
        $sql = mysqli_query($conn, "SELECT COUNT(*) as total_archived FROM user WHERE STATUS = 'archived'");
        $row = mysqli_fetch_assoc($sql);
        $total_archived = $row['total_archived'];
        mysqli_close($conn);
        ?>
        <h2><?php echo $total_archived; ?></h2>
        <p style="color: black;">Total User Archived</p>
    </div>
</div>

<!-- Pie Chart Section -->
<div id="chart-container">
    <canvas id="gradeChart"></canvas>
</div>

<?php
include 'db.php';

// Fetch grade-level data
$grade_levels = [];
$student_count = [];

// Loop through grade levels and fetch count
for ($grade = 7; $grade <= 12; $grade++) {
    $grade_key = "grade" . $grade; // Construct the database value (e.g., 'grade7', 'grade8')
    $sql = mysqli_query($conn, "SELECT COUNT(*) as total_students FROM student_info WHERE PROGRAM = '$grade_key'");
    $row = mysqli_fetch_assoc($sql);
    $grade_levels[] = "Grade $grade"; // Label for chart
    $student_count[] = $row['total_students']; // Student count for chart
}

mysqli_close($conn);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from PHP
    const gradeLevels = <?php echo json_encode($grade_levels); ?>;
    const studentCounts = <?php echo json_encode($student_count); ?>;

    // Chart.js Pie Chart
    const ctx = document.getElementById('gradeChart').getContext('2d');
    const gradeChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: gradeLevels,
            datasets: [{
                data: studentCounts,
                backgroundColor: [
                    '#28a745', // Grade 7 - Simple Green
                    '#ffc107', // Grade 8 - Simple Yellow
                    '#dc3545', // Grade 9 - Simple Red
                    '#007bff', // Grade 10 - Simple Blue
                    '#800000', // Grade 11 - Simple Maroon
                    '#87ceeb'  // Grade 12 - Sky Blue
                ],
                hoverBackgroundColor: [
                    '#218838', // Grade 7 Hover - Slightly Darker Green
                    '#e0a800', // Grade 8 Hover - Slightly Darker Yellow
                    '#c82333', // Grade 9 Hover - Slightly Darker Red
                    '#0056b3', // Grade 10 Hover - Slightly Darker Blue
                    '#6a0000', // Grade 11 Hover - Darker Maroon
                    '#6fb6d6'  // Grade 12 Hover - Slightly Darker Sky Blue
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const index = tooltipItem.dataIndex;
                            const count = studentCounts[index];
                            return `${gradeLevels[index]}: ${count} students`;
                        }
                    }
                }
            }
        }
    });
</script>

