<?php 
include 'auth.php';

$request = $_SERVER['REQUEST_URI'];

if (strpos($request, '.php') !== false) {
    $new_url = str_replace('.php', '', $request);
    header("Location: $new_url", true, 301);
    exit();
}

$timeout_duration = 1800;

if (isset($_SESSION['LAST_ACTIVITY'])) {
    $elapsed_time = time() - $_SESSION['LAST_ACTIVITY'];

    if ($elapsed_time > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: logout.php");
        exit();
    }
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="images/logo.jpg"> -->
    <title>MNHS - Student Grading System</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
    <link href="asset/css/plugins/morris.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css">
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body style="background-color: white;">

    <div id="wrapper">

        <!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="col-md-1">
          <!-- <img src="" style="height:48px;width:50px;align:center" alt=""> -->
        </div>
                            
        <a class="navbar-brand" href=""><b>&nbsp;&nbsp;&nbsp; MNHS - Student Grading System</b></a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
      <?php
        include 'db.php';

        $stmt = $conn->prepare("SELECT * FROM user WHERE USER_ID = ?");
        $stmt->bind_param("s", $_SESSION['ID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the user is not an administrator
        if ($row['USER_TYPE'] != 'FACULTY TEACHER') {
        ?>
            <!-- Notifications Dropdown -->
            <li class="dropdown notifications" >
            <?php
                // Count the number of new notifications for non-admin users
                $notifications_query = $conn->prepare(
                    "SELECT COUNT(*) as new_count 
                    FROM history_log hl
                    INNER JOIN user u ON hl.user_id = u.USER_ID
                    WHERE (hl.status='Add' OR hl.status='Update')
                    AND u.USER_TYPE = 'FACULTY TEACHER'"
                );
                $notifications_query->execute();
                $notification_row = $notifications_query->get_result()->fetch_assoc();
                $new_notifications_count = $notification_row['new_count'];
            ?>

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i> 
                    <?php if ($new_notifications_count > 0): ?>
                        <span class="badge" style="background-color:red;"><?php echo $new_notifications_count; ?></span>
                    <?php endif; ?>
                </a>

                <ul class="dropdown-menu" style="width:150px;border-radius:5px;max-height: 200px; overflow-y: auto;">
    <h6 style="text-align:center;padding-bottom:5px;border-bottom:2px solid black;font-size:10px;margin-bottom:-2px;margin-top:2px;">You have new notifications</h6>
    <?php
        // Get the list of notifications
        $notifications = $conn->prepare(
            "SELECT * FROM history_log hl
            INNER JOIN user u ON hl.user_id = u.USER_ID
            WHERE u.USER_TYPE = 'FACULTY TEACHER' AND (hl.status='Add' OR hl.status='Update')
            ORDER BY hl.status IN ('Add','Update') AND date_added desc"
        );
        $notifications->execute();
        $result_notifications = $notifications->get_result();

        while ($notification = $result_notifications->fetch_assoc()) {
            $trans = $notification['transaction'];
            $notification_id = $notification['log_id'];
            $status = $notification['status']; // Assuming 'status' is a column in the 'history_log' table
            $student_grade = $notification['grade'];  // Change 'grade' to the actual column name for the grade
            $student_id = $notification['student_id']; // Assuming there's a 'student_id' field in the history_log table

            // Set the URL based on the student's grade
            $page_url = "rms.php?page=" . strtolower($student_grade);  // Converts the grade to lowercase (e.g., grade7 -> grade7)

            // Determine the background color based on the status
            $background_color = 'transparent'; // Default background for 'read' notifications
            if ($status == 'Add' || $status == 'Update') {
                $background_color = 'skyblue'; // Background for 'Add' or 'Update' notifications
            }

            // URL for the history log page based on student ID
            $history_url = "rms.php?page=record&id=" . $student_id;
            $subject_page = "rms?page=subjects";

            if($student_id > 0){
              // Second list item (for history log page)
            echo '<li style="font-size:10px;border-bottom:1px solid gray; background-color:' . $background_color . ';">';
            echo '<a href="' . $history_url . '" class="mark-as-read" data-notification-id="' . $notification_id . '">' . $trans . '</a>';
            echo '</li>';
            
            } else if($student_grade > 0) {
              // First list item (for grade-based page)
            echo '<li style="font-size:10px;border-bottom:1px solid gray; background-color:' . $background_color . ';">';
            echo '<a href="' . $page_url . '" class="mark-as-read" data-notification-id="' . $notification_id . '">' . $trans . '</a>';
            echo '</li>';
            } else {
              echo '<li style="font-size:10px;border-bottom:1px solid gray; background-color:' . $background_color . ';">';
              echo '<a href="' . $subject_page . '" class="mark-as-read" data-notification-id="' . $notification_id . '">' . $trans . '</a>';
              echo '</li>';
            }
        }
    ?>
</ul>

            </li>
      <?php } ?>
        
        <!-- User Dropdown -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
            <?php echo $_SESSION['fname']?>
                <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                     <a href="" data-toggle="modal" data-target="#new_user"><i class="fa fa-fw fa-pencil"></i>Account</a>
                </li>
               <li class="divider"></li>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
    <?php 
    include 'db.php';

    $sql = mysqli_query($conn,"SELECT * FROM user where USER_ID = '".$_SESSION['ID']."'");
    $row = mysqli_fetch_assoc($sql);
    if($row['USER_TYPE'] == 'ADMINISTRATOR'){
        include 'sidebar.php';
    }else{
        include 'sidebar_staff.php';
    }
    ?>
    </div>
    <!-- /.navbar-collapse -->
</nav>



            <div class="container-fluid">

<?php
error_reporting(E_ALL ^ E_NOTICE);

$page = $_GET['page'];
$pages = array('home', 'grade7', 'grade8', 'grade9', 'grade10', 'grade11', 'grade12', 'subjects','student_p','records','record','addrecord','report','program','statistical','form137','list_report','student_report','users','school_year','grade','advisers','database','candidates','candidates_list', 'candidates_report','logs', 'archive', 'updateRecord', 'addrow_grades');
if (!empty($page)) {
    if(in_array($page,$pages)) {
        $page .= '.php';
        include($page);
    }
    else {
        echo 'Page not found. Return
        <a href="rms.php?page=home">home</a>';
    }
}

?>

            </div>
    </div>
    <div class="modal fade" id="new_user" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Account</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?php
                    include 'db.php';
                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE USER_ID = '" . $_SESSION['ID'] . "'");
                    while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                        <form id="updateAccountForm" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-1" for="fname">Firstname:</label>
                                <div class="col-sm-3">  
                                    <input type="hidden" name="id" value="<?php echo $row['USER_ID'] ?>" >
                                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['FIRSTNAME'] ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-1" for="lname">Lastname:</label>
                                <div class="col-sm-3">          
                                    <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row['LASTNAME'] ?>" >
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="control-label col-sm-1" for="user">User:</label>
                                <div class="col-sm-3">          
                                    <input type="text" class="form-control" id="user" name="user" value="<?php echo $row['USER'] ?>" >
                                </div>
                            </div>    
                            <div class="form-group">
                                <label class="control-label col-sm-1" for="pwd">User Type:</label>
                                <div class="col-sm-3">   
                                    <select class="form-control" name="type" id="sel1">
                                        <option><?php echo $row['USER_TYPE'] ?></option>
                                        <?php
                                        if ($row['USER_TYPE'] == "FACULTY TEACHER") { ?>
                                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                                        <?php } else { ?>
                                            <option value="FACULTY TEACHER">FACULTY TEACHER</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-offset-2">
                    <button type="button" id="saveButton" class="btn btn-default">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

      <div class="modal fade" id="s_report" role="dialog">
                <div class="modal-dialog modal-sm">
     
                     
                <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Student List Report</h4>
                        </div>
                    <div class="modal-body">
                    <div class="container">
                    <div class="form-group">
                    <form action="rms.php?page=list_report" method="POST">
                      <label class="control-label col-sm-3" for="pd">School Year:</label>
                      <br><br>
                      <div class="col-sm-2">          
                       <select class="form-control" name="sy" id="pd">
                        <option ></option>
                        <?php
                        include 'db.php';
                        $query= mysqli_query($conn,"SELECT SCHOOL_YEAR as sy FROM student_year_info GROUP BY SCHOOL_YEAR Order By SCHOOL_YEAR DESC");
                        while($row = mysqli_fetch_assoc($query)){
                        ?>
                          <option><?php echo $row['sy'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="w">Status:</label>
                      <br><br>
                      <div class="col-sm-2">   
                        <select class="form-control" name="stats" id="w">
                        <option ></option>
                          <option>Promoted</option>
                          <option>Retained</option>n>
                        </select>
                      </div>
                    </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-success " name="submitb" value="View">
                      </form>
                      
                          <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                </div>
                 </div>
                 </div>
                  <div class="modal fade" id="stats" role="dialog">
                <div class="modal-dialog modal-sm">
     
                     
                <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Select School Year</h4>
                        </div>
                    <div class="modal-body">
                    <div class="container">
                    <div class="form-group">
                    <form action="rms.php?page=statistical" method="POST">
                      <label class="control-label col-sm-3" for="pd">School Year:</label>
                      <br><br>
                      <div class="col-sm-2">          
                       <select class="form-control" name="sy" id="pd">
                        <option ></option>
                        <?php
                        include 'db.php';
                        $query= mysqli_query($conn,"SELECT SCHOOL_YEAR as sy FROM student_year_info GROUP BY SCHOOL_YEAR Order By SCHOOL_YEAR DESC");
                        while($row = mysqli_fetch_assoc($query)){
                        ?>
                          <option><?php echo $row['sy'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                   
                    </div>
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-success " name="submitb" value="View">
                      </form>
                      
                          <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                </div>
                 </div>
                 </div>
    <script>
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 5000); // Change image every 2 seconds
}

</script>


    <script src="assets/js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
  // Wait for the document to be ready
  $(document).ready(function() {
        // Add a click event handler for all links with the class 'mark-as-read'
        $('.mark-as-read').on('click', function(e) {
            e.preventDefault();  // Prevent the default link behavior

            var notificationId = $(this).data('notification-id');  // Get the notification ID from the data attribute

            // Send an AJAX request to mark the notification as read
            $.ajax({
                url: 'mark_as_read.php',  // The PHP script that handles the update
                type: 'POST',
                data: { notification_id: notificationId },
                success: function(response) {
                    // Optionally, handle success (e.g., show a message, change notification style, etc.)
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });

            // Optionally, you can redirect to the page after marking the notification as read
            window.location.href = $(this).attr('href');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#saveButton').click(function() {
            var formData = $('#updateAccountForm').serialize();

            $.ajax({
                url: 'update_account.php', // URL to the PHP script for processing the form
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Optionally reload the page or close the modal
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            });
        });
    });
</script>

</body>

</html>
