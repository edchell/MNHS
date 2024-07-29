<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $id = $_POST['id'];
    $lrn = $_POST['lrn'];
    $ln = $_POST['lname'];
    $fn = $_POST['fname'];
    $mn = $_POST['mname'];
    $gender = $_POST['gender'];
    $bp = $_POST['bp'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $pg = $_POST['pg'];
    $pga = $_POST['pga'];
    $icc = $_POST['icc'];
    $sy = $_POST['sy'];
    $tny = $_POST['tny'];
    $ave = $_POST['ave'];
    $prog = $_POST['prog'];
    $user = $_SESSION['ID'];

    include 'db.php'; // Ensure this file is correctly setting up $conn

    // Check if LRN already exists
    $search_query = mysqli_query($conn, "SELECT * FROM student_info WHERE LRN_NO = '$lrn' AND STUDENT_ID != '$id'");
    $num_row = mysqli_num_rows($search_query);

    if ($num_row >= 1) {
        // LRN exists, show alert and redirect
        echo '<script>
            alert("LRN is not available.");
            location.replace(document.referrer);
        </script>';
    } else {
        // Update student information
        $sql = "UPDATE student_info SET
            LRN_NO = '$lrn',
            LASTNAME = '$ln',
            FIRSTNAME = '$fn',
            MIDDLENAME = '$mn',
            BIRTH_PLACE = '$bp',
            PARENT_GUARDIAN = '$pg',
            P_ADDRESS = '$pga',
            INT_COURSE_COMP = '$icc',
            SCHOOL_YEAR = '$sy',
            GEN_AVE = '$ave',
            TOTAL_NO_OF_YEARS = '$tny',
            DATE_OF_BIRTH = '$dob',
            ADDRESS = '$address',
            GENDER = '$gender',
            PROGRAM = '$prog'
            WHERE STUDENT_ID = '$id'";

        if (mysqli_query($conn, $sql)) {
            // Log the update
            mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) 
                VALUES ('updated $id in the student list', '$user', NOW())");

            // Success message
            echo '<div id="message" class="alert-success"><center><h4>Data Successfully updated.</h4></center></div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("message").style.display = "none";
                }, 2000);
            </script>';
        } else {
            // Error message
            echo '<script>
                alert("Failed to Submit.");
                location.replace(document.referrer);
            </script>';
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>
