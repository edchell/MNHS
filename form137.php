<!DOCTYPE html>
<html>
<?php 
include 'db.php';
session_start();
$user = $_SESSION['ID'];
$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM student_info WHERE STUDENT_ID = '$id'");
$row = mysqli_fetch_assoc($query);
$student = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];

mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) 
    VALUES ('Printed $student permanent record', '$user', NOW())");

mysqli_close($conn);
?>
<head>
    <link rel="icon" href="images/logo.jpg">
    <title>Student Grading System</title>

    <!-- Bootstrap Core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="asset/css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="asset/css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">

    <script src="assets/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>

    <style>
        @media print {  
            @page {
                size: 8.5in 13in;
            }
            body {
                margin: 0;
                padding: 0;
            }
            #head, #returncode {
                display: none;
            }
            #print {
                margin: 0;
                padding: 0;
                width: 7.5in;
                position: fixed;
                top: 0;
                left: 0;
            }
        }
        #print {
            width: 7.5in;
        }
        input {
            border: 0;
            outline: 0;
            background: transparent;
            border-bottom: 1px solid black;
        }
        .foo {
            font-family: "Bodoni MT", Didot, "Didot LT STD", "Hoefler Text", Garamond, "Times New Roman", serif;
            font-size: 24px;
            font-style: italic;
            font-weight: bold;
            line-height: 24px;
        }
        .p {
            font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            font-style: italic;
            font-weight: 550;
            line-height: 20px;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <div id="head">
        <button class="btn btn-info" onclick="printContent('print')">Print</button>
        <a class="btn btn-info" onclick="window.close()">Cancel</a>
    </div>
    <center>
        <div id="print">
            <div style="margin: 0.5in;">
                <p><center><b>MNHS Student Grading System</b></center></p>
                <div class="row">
                    <div class="col-md-12">
                        <center><p><b><h4>SECONDARY STUDENT'S PERMANENT RECORDS</h4></b></p></center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table style="line-height: 1.5mm;">
                            <?php 
                            include 'db.php';
                            $id = $_GET['id'];
                            $sql = mysqli_query($conn, "SELECT * FROM student_info WHERE STUDENT_ID = '$id'");
                            while($row = mysqli_fetch_assoc($sql)){
                                $mid = $row['MIDDLENAME'];
                            ?>
                            <tr>
                                <td style="width: 600px; font-size: 12px;">
                                    <label>Name: </label>
                                    <b style="font-size: 13px; text-transform: uppercase;"><?php echo $row['LASTNAME'] . ", " . $row['FIRSTNAME'] . " " . substr($mid, 0, 1) . "."; ?></b>
                                    <br>
                                    <label>Place of Birth: </label>
                                    <span style="font-size: 12px;"><?php echo $row['BIRTH_PLACE']; ?></span>
                                </td>
                                <td style="width: 600px; font-size: 12px;">
                                    <label>Date of Birth: </label>
                                    <span style="font-size: 12px;"><?php echo date("F d, Y"); ?></span>
                                    <br>
                                    <label>Town / City: </label>
                                    <span style="font-size: 12px;"><?php echo $row['ADDRESS']; ?></span>
                                </td>
                            </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 1000px; font-size: 12px;">
                                        <label>Parent or Guardian: </label>
                                        <span style="font-size: 12px; text-transform: capitalize;"><?php echo $row['PARENT_GUARDIAN']; ?></span>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 1000px; font-size: 12px;">
                                        <label>Address of Parent or Guardian: </label>
                                        <span style="font-size: 12px; text-transform: capitalize;"><?php echo $row['P_ADDRESS']; ?></span>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td style="width: 800px; font-size: 12px;">
                                        <label>Intermediate Course Completed at: </label>
                                        <span style="text-transform: capitalize;"><?php echo $row['INT_COURSE_COMP']; ?></span>
                                    </td>
                                    <td style="width: 200px; font-size: 12px;">
                                        <label>Year: </label>
                                        <span style="text-transform: capitalize;"><?php echo $row['SCHOOL_YEAR']; ?></span>
                                    </td>
                                    <td style="width: 200px; font-size: 12px;">
                                        <label>Average: </label>
                                        <span style="text-transform: capitalize;"><?php echo $row['GEN_AVE']; ?></span>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr style="border: 1px solid black;">
                            </div>
                        </div>
                        <p>
                            <?php
                            $sql1 = mysqli_query($conn, "SELECT * FROM student_year_info LEFT JOIN grade ON student_year_info.YEAR = grade.grade_id WHERE STUDENT_ID = '$id'");
                            while($row1 = mysqli_fetch_assoc($sql1)){
                            ?>
                            <table style="float: left; margin-bottom: 20px;">
                                <tr>
                                    <td>
                                        <table>
                                            <tr style="width: 100%;">
                                                <td>
                                                    <label style="font-size: 12px;">School: </label>
                                                </td>
                                                <td style="border-bottom: 1px solid black; width: 280px;">
                                                    <label style="font-size: 12px;"><?php echo $row1['SCHOOL']; ?></label>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr style="width: 100%;">
                                                <td style="width: 200px;">
                                                    <label style="font-size: 12px;">Year & Section: </label>
                                                    <span><?php echo $row1['grade'] . '-' . $row1['SECTION']; ?></span>
                                                </td>
                                                <td>
                                                    <label style="font-size: 12px;">School Year: </label>
                                                    <span><?php echo $row1['SCHOOL_YEAR']; ?></span>
                                                </td>
                                            </tr>
                                        </table>
                                        <table style="border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 150px; border: 1px solid black; font-size: 12px;">Subject</td>
                                                <td style="width: 50px; border: 1px solid black; font-size: 12px;">1st</td>
                                                <td style="width: 50px; border: 1px solid black; font-size: 12px;">2nd</td>
                                                <td style="width: 50px; border: 1px solid black; font-size: 12px;">3rd</td>
                                                <td style="width: 50px; border: 1px solid black; font-size: 12px;">4th</td>
                                                <td style="width: 50px; border: 1px solid black; font-size: 12px;">Final</td>
                                            </tr>
                                            <?php
                                            $sql2 = mysqli_query($conn, "SELECT * FROM grades WHERE YEAR = '$row1[YEAR]' AND STUDENT_ID = '$id'");
                                            while($row2 = mysqli_fetch_assoc($sql2)){
                                            ?>
                                            <tr>
                                                <td style="border: 1px solid black; font-size: 12px;"><?php echo $row2['SUBJECT']; ?></td>
                                                <td style="border: 1px solid black; font-size: 12px;"><?php echo $row2['1ST']; ?></td>
                                                <td style="border: 1px solid black; font-size: 12px;"><?php echo $row2['2ND']; ?></td>
                                                <td style="border: 1px solid black; font-size: 12px;"><?php echo $row2['3RD']; ?></td>
                                                <td style="border: 1px solid black; font-size: 12px;"><?php echo $row2['4TH']; ?></td>
                                                <td style="border: 1px solid black; font-size: 12px;"><?php echo $row2['FINAL']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
            <script>
                function printContent(el){
                    var restorePage = document.body.innerHTML;
                    var printContent = document.getElementById(el).innerHTML;
                    document.body.innerHTML = printContent;
                    window.print();
                    document.body.innerHTML = restorePage;
                }
            </script>
        </center>
    </body>
    </html>
