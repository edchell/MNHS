<?php include 'auth.php' ?>
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
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>


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
               <!-- Notifications Dropdown -->
        <li class="dropdown notifications">
            <?php
            include 'db.php';
                // Count the number of new notifications
                $notifications_query = mysqli_query($conn, "SELECT COUNT(*) as new_count FROM notifications WHERE user_id = '".$_SESSION['ID']."' AND status = 'New'");
                $notification_row = mysqli_fetch_assoc($notifications_query);
                $new_notifications_count = $notification_row['new_count'];
            ?>

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell"></i> 
                <?php if($new_notifications_count > 0): ?>
                    <span class="badge" style="background-color:red;"><?php echo $new_notifications_count; ?></span>
                <?php endif; ?>
            </a>

            <ul class="dropdown-menu" style="width:300px;">
            <h6 style="text-align:center;padding-bottom:5px;border-bottom:2px solid black;">You have new notifications</h6> <!-- Header for notifications -->
                <?php
                    // Get the list of notifications
                    $notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id = '".$_SESSION['ID']."' AND status = 'New' ORDER BY created_at DESC LIMIT 5");
                    while ($notification = mysqli_fetch_assoc($notifications)) {
                      $id = $notification['student_id'];
                      $notification_id = $notification['notification_id'];
                      $query = mysqli_query($conn, "SELECT * FROM student_info WHERE STUDENT_ID = '$id'");
                      $row = mysqli_fetch_assoc($query);
                      $student = $row['FIRSTNAME']. ' ' .$row['LASTNAME'];
                      echo '<li style="font-size:14px;border-bottom:1px solid gray;">';
                      echo '<a href="rms.php?page=record&id='.$id.'" class="mark-as-read" data-notification-id="'.$notification_id.'">New student record added for <b>'. $student .'</b></a>';
                      echo '</li>';
                    }
                ?>
            </ul>
        </li>
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
$pages = array('home', 'Students', 'subjects','student_p','records','record','addrecord','report','program','statistical','form137','list_report','student_report','users','school_year','grade','advisers','database','candidates','candidates_list', 'candidates_report','logs', 'archive');
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
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manage Acount</h4>
        </div>
        <div class="modal-body">
        <div class="container">
         <?php
    include 'db.php';
    $sql=  mysqli_query($conn, "SELECT * FROM user where USER_ID = '".$_SESSION['ID']."'");
    while($row = mysqli_fetch_assoc($sql)) {


    ?>
        <form class="form-horizontal" method="post" action="update_account.php">
              <div class="form-group">
      <label class="control-label col-sm-1" for="fname">Firstname:</label>
      <div class="col-sm-3">  
              <input type="hidden" class="form-control" name="id" value="<?php echo $row['USER_ID'] ?>" >
        
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
        <option><?php echo $row['USER_TYPE']?></option>
        <?php
        if($row['USER_TYPE'] == "FACULTY TEACHER"){ ?>
          <option value="ADMINISTRATOR">ADMINISTRATOR</option>
        <?php }else{?>
          <option value="FACULTY TEACHER">FACULTY TEACHER</option>
        <?php } ?>
        </select>
      </div>
    </div>
    <?php } ?>
          
        </div>
          
        </div>
        <div class="modal-footer">
        <div class="col-md-offset-2">
        <button type="submit" class="btn btn-default">Save</button>
        </form>
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

</body>

</html>
