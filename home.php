<?php
$servername = "127.0.0.1";
$username = "u510162695_grading_db";
$password = "1Grading_db";
$dbname = "u510162695_grading_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$user_count = 0;
$subject_count = 0;
$male_count = 0;
$female_count = 0;

// Query to get number of users
$sql_users = "SELECT COUNT(*) AS user_count FROM user";
$result_users = $conn->query($sql_users);

if ($result_users) {
    if ($result_users->num_rows > 0) {
        // Output data of the first row
        $row_users = $result_users->fetch_assoc();
        $user_count = $row_users["user_count"];
    }
} else {
    echo "Error: " . $sql_users . "<br>" . $conn->error;
}
// subject
$sql_users = "SELECT COUNT(*) AS subject_count FROM subjects";
$result_users = $conn->query($sql_users);

if ($result_users) {
    if ($result_users->num_rows > 0) {
        // Output data of the first row
        $row_users = $result_users->fetch_assoc();
        $subject_count = $row_users["subject_count"];
    }
} else {
    echo "Error: " . $sql_users . "<br>" . $conn->error;
}

// Query to get count of male students
$sql_male_students = "SELECT COUNT(*) AS male_count FROM student_info WHERE gender = 'male'";
$result_male_students = $conn->query($sql_male_students);

if ($result_male_students) {
    if ($result_male_students->num_rows > 0) {
        // Output data of the first row
        $row_male_students = $result_male_students->fetch_assoc();
        $male_count = $row_male_students["male_count"];
    } else {
        $male_count = 0; // default to 0 if no male students found
    }
} else {
    echo "Error: " . $sql_male_students . "<br>" . $conn->error;
}

// Query to get count of female students
$sql_female_students = "SELECT COUNT(*) AS female_count FROM student_info WHERE gender = 'female'";
$result_female_students = $conn->query($sql_female_students);

if ($result_female_students) {
    if ($result_female_students->num_rows > 0) {
        // Output data of the first row
        $row_female_students = $result_female_students->fetch_assoc();
        $female_count = $row_female_students["female_count"];
    } else {
        $female_count = 0; // default to 0 if no female students found
    }
} else {
    echo "Error: " . $sql_female_students . "<br>" . $conn->error;
}

// Initialize an empty array for subjects
$subjects = array();

// Query to fetch subjects from the database
$sql_subjects = "SELECT SUBJECT FROM subjects";
$result_subjects = $conn->query($sql_subjects);

if ($result_subjects->num_rows > 0) {
    // Loop through each row and add subject names to the $subjects array
    while ($row = $result_subjects->fetch_assoc()) {
        $subjects[] = $row['SUBJECT']; // Use 'SUBJECT' instead of 'subject_name'
    }
}

$conn->close();
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        .body {
            text-align: center;
            display: flex;
        }
        /* Card box styling */
        .card-box-1 {
            background-color: #cce5ff; /* Light Blue color */
            min-height: 200px; /* Ensure the card has a minimum height */
            max-height: 200px; /* Set a max height to make it scrollable */
            overflow-y: auto; /* Enable vertical scrolling */
            padding: 20px; /* Add padding for spacing */
            border-radius: 8px; /* Optional: rounded corners */
        }

        .font-18-1 {
            font-size: 20px; /* Font size */
        }
        
        .mb-20-1 {
            margin-bottom: 20px; /* Margin bottom */
        }
        
        .text-black-1 {
            color: #000; /* Text color */
        }
        
        .d-flex-1 {
            display: flex;
        }
        
        .justify-content-between-1 {
            justify-content: space-between;
        }
        
        .pb-20-1 {
            padding-bottom: 20px;
        }
        
        .min-height-200px-1 {
            min-height: 200px;
        }
        
        .icon-1 {
            font-size: 1em; /* Adjust icon size */
        }
        
        .font-15-1 {
            font-size: 15px; /* Font size for subtitle */
        }
        
        .text-right-1 {
            text-align: right;
        }
    </style>

<!-- HTML Structure -->
<div class="xs-pd-20-10 pd-ltr-20">
    <div class="title pb-20">
        <h2 class="h3 mb-0">School Overview</h2>
    </div>

    <div class="row pb-10">
        <!-- Users Section -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3" style="background-color: #ffebcc;"> <!-- Light Orange color -->
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo $user_count; ?></div>
                        <div class="font-20 text-secondary weight-500">
                        <center>  Users  </center>
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" style="color: #ffa500;"> <!-- Orange color -->
                            <i class="icon-copy fa fa-user-circle" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Male Students Section -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3" style="background-color: #e6f7ff;"> <!-- Light Blue color -->
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo $male_count; ?></div>
                        <div class="font-18 text-secondary weight-500">
    <center> Total Male Students </center> 
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" style="color: DodgerBlue;"> <!-- DodgerBlue color -->
                            <i class="icon-copy fa fa-male" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Female Students Section -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3" style="background-color: #f9e6ff;"> <!-- Light Pink color -->
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo $female_count; ?></div>
                        <div class="font-18 text-secondary weight-500">
                        <center>   Total Female Students </center> 
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" style="color: #ee82ee;"> <!-- PInk color -->
                            <i class="icon-copy fa fa-female" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students Section -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3" style="background-color: #dfffd6;"> <!-- Light Green color -->
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo $male_count + $female_count; ?></div>
                        <div class="font-18 text-secondary weight-500">
                        <center>  Total Students </center> 
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" style="color: #3cb371;"> <!-- Medium Sea Green color -->
                            <i class="icon-copy fa fa-mortar-board" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
    </div>

 <!-- Subjects Section -->
<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
    <div class="card-box height-100-p widget-style3" style="background-color: #fde0e0;"> <!-- Soft peach color -->
        <div class="d-flex flex-wrap">
            <div class="widget-data">
                <div class="weight-700 font-24 text-dark"><?php echo $subject_count; ?></div>
                <div class="font-18 text-secondary weight-500">
                <center>   Subjects  </center> 
                </div>
            </div>
            <div class="widget-icon">
                <div class="icon" style="color: #d1c4e9;"> <!-- Peachs color -->
                    <i class="icon-copy fa fa-user-circle" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</div>




    <!--<div class="col-md-4 mb-20">
        <div class="card-box min-height-200px pd-20" style="background-color: #265ed7;">
            <div class="d-flex justify-content-between pb-20 text-white">
                <div class="icon h1 text-white">
                    <i class="fa fa-stethoscope" aria-hidden="true"></i>
                </div>
                <div class="font-14 text-right">
                    <div><i class="icon-copy ion-arrow-down-c"></i> 3.69%</div>
                    <div class="font-12">Since last month</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="text-white">
                    <div class="font-14">Surgery</div>
                    <div class="font-24 weight-500">250</div>
                </div>
                <div class="max-width-150">
                    <div id="surgery-chart"></div>
                </div>
            </div>
        </div>
    </div>-->
</div>
